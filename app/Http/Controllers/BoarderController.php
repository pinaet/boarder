<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use App\Models\Attendance;
use App\Models\SchoolTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoarderController extends Controller
{
    public function dashboard()
    {
        $boarders    = Boarder::where('status','Current')->orderBy('prefered_forename')->take(3)->get();
        $boarders    = $this->prepare_boarders( $boarders );
        $attendances = Attendance::all();
        $buildings   = Building::all();

        $dates       = $this->generate_dates();

        $term        = $this->generate_term();

        // $building = 'West Acre';
        return Inertia::render('Dashboard', [
            'all_boarders'  => $boarders,
            'attendances'   => $attendances,
            'buildings'     => $buildings,
            'dates'         => $dates,
            'term'          => $term,
        ]);
    }

    public function update_profile()
    {
        $c_boarder  = request()->boarder;

        $building   = Building::where('building_name', $c_boarder['building_name'])->first();
        Boarder::where('pupil_id', $c_boarder['pupil_id'])
                ->update([
                    'telephone'          => $c_boarder['telephone'],
                    'offsite_permission' => $c_boarder['offsite_permission'],
                    'building_id'        => $building->id
                ]);
        $data['message'] = 'OK 200';
        return $data;
    }

    public function change_building()
    {
        $building_name  = request()->building;

        if( $building_name=='All' )
        {
            $boarders = Boarder::where( 'status', 'Current' )
                                ->orderBy( 'prefered_forename' )->take(10)->get();
        }
        else
        {
            $building = Building::where('building_name', $building_name)->first();
            $boarders = Boarder::where( 'status', 'Current' )
                                ->where( 'building_id', $building->id )
                                ->orderBy( 'prefered_forename' )->take(10)->get();
        }

        $boarders = $this->prepare_boarders( $boarders );

        $data = [
            'boarders' => json_decode($boarders),
            'message'  => 'OK 200 - Boarders',
        ];
        
        return $data;
    }

    function prepare_boarders( $boarders )
    {
        foreach( $boarders as $boarder )
        {
            if( env('DB_CONNECTION')=='sqlsrv' ){
                // $photo = DB::raw('CONVERT(VARBINARY(MAX), 0x' . bin2hex($boarder->Photo) . ')'); //To get the value out of the database use hex2bin($attachment)
                // $boarder->Photo    = '0x' . bin2hex($boarder->Photo);    
                $string     = str_replace(' ','', $boarder->photo);
                $sData      = $string;
                $sData      = substr( $sData, 2, strlen( $sData ) -2 );
                $sData      = base64_encode( pack("H*", $sData) );
            }
            else{
                $sData = base64_encode( $boarder->photo );
            }
            $boarder->photo = $sData;
            $boarder->{'building_name'} = $boarder->building->building_name;
            $boarder->{'contacts'}      = $boarder->contacts;
            // dd($boarder->contacts,$boarder->building->building_name,$boarder);
        }

        return $boarders;
    }

    function generate_dates()
    {
        // N = 1-7
        // L = 1:LeapYear 0:notLeapYear
        // l = Monday - Sunday
        // D = Mon - Sun
        // j = 1 - 31
        // m = 01 - 12
        // M = Jan - Dec
        // F = January - December
        // Y = YYYY

        $dates = array();
        $week_days = [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
        ];

        $date = array(
            'date_long'  => '',
            'date_short' => '',
            'formatted'  => '',
            'day'        => '',
            'day_short'  => '',
            'order'      => '',
        );

        //get current date
        $order = date( 'N' ) - 1;
        foreach( $week_days as $index => $value )
        {
            $temp     = '';
            $key_word = '';
            if( $index > $order ){
                $key_word = 'next ' . $value;
            }
            if( $index < $order ){
                $key_word = 'last ' . $value;
            }

            if( $key_word ){
                $temp = date( 'Y-m-d', strtotime( $key_word ) );
            }
            else{
                $temp = date( 'Y-m-d' );
            }
            
            // if( $index>0 ) dd($index,$value,$order,$key_word,$temp);

            $date = array(
                'date_long'  => date( 'j F Y', strtotime( $temp ) ),
                'date_short' => date( 'j M Y', strtotime( $temp ) ),
                'formatted'  => $temp,
                'day'        => date( 'l', strtotime( $temp ) ),
                'day_short'  => date( 'D', strtotime( $temp ) ),
                'order'      => $index, //== date( 'N', strtotime( $temp ) ) - 1,
                'status'     => !$key_word ? 'current' : '',
            );

            array_push( $dates, $date );
        }
        
        return $dates;
    }

    function generate_term( $date='' )
    {
        if( $date=='' ){
            $date = date('Y-m-d');
        }

        $term   = SchoolTerm::where('start_date', '<', $date)->where('end_date', '>', $date)->get()[0];

        if( $term ){
            $term->{'weeks'} = datediff( 'ww', $term->start_date, $date );
            $term->{'name'}  = $term->academic_year . '-' . ($term->academic_year+1-2000) .' Term '. $term->term .' ( Week '.$term->weeks.' )';
        }
        
        return $term;
    }
}
