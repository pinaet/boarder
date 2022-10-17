<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use App\Models\Attendance;
use App\Models\RegisterColumn;
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

        $cols        = $this->generate_cols();

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

    public function change_week()
    {
        $term      = request()->term;
        $direction = request()->direction;
        $word      = '';

        if( $direction=='previous' )
        {
            $word      = '-1 week';
        }
        else
        {
            $word      = '+1 week';
        }
        // dd( $direction, $term );

        $seed_date = date( 'Y-m-d', strtotime( $word . ' ' . $term['date'] ) );

        $dates = $this->generate_dates( $seed_date );
        $term  = $this->generate_term(  $seed_date );

        $data = [
            // 'boarders' => json_decode($boarders),
            'dates'    => $dates,
            'term'     => $term,
            'message'  => 'OK 200 - change_week',
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

    function generate_dates( $seed_date='' )
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
        if( $seed_date ){
            $order = date( 'N', strtotime( $seed_date ) ) - 1;
        }
        else{
            $order = date( 'N' ) - 1;
        }

        foreach( $week_days as $index => $value )
        {
            $temp     = '';
            $key_word = '';
            if( $index > $order ){
                $key_word = "next $value $seed_date";
            }
            if( $index < $order ){
                $key_word = "last $value $seed_date";
            }

            $status = '';
            if( $key_word ){
                $temp   = date( 'Y-m-d', strtotime( $key_word ) );
                $status = '';
            }
            else{
                if( $seed_date ){
                    $temp   = date( 'Y-m-d', strtotime( $seed_date ) );
                }
                else{
                    $temp   = date( 'Y-m-d' );
                    $status = 'current';
                }
            }
            
            // if( $index>0 ) dd($index,$value,$order,$key_word,$temp);

            $date = array(
                'date_long'  => date( 'j F Y', strtotime( $temp ) ),
                'date_short' => date( 'j M Y', strtotime( $temp ) ),
                'formatted'  => $temp,
                'day'        => date( 'l', strtotime( $temp ) ),
                'day_short'  => date( 'D', strtotime( $temp ) ),
                'order'      => $index, //== date( 'N', strtotime( $temp ) ) - 1,
                'status'     => $status,
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

        $start_date = '';
        $term       = SchoolTerm::where('start_date', '<', $date)->where('end_date', '>', $date)->get();
        if( isset($term[0]) ){
            $term       = $term[0];
            $start_date = SchoolTerm::where( 'academic_year', $term->academic_year )->where( 'term', 'Term 1' )->get()[0]->start_date;
        }
        else{
            $sql = "
                select * from
                (
                    select academic_year, '-' term, min(start_date) start_date, max(end_date) end_date from chirper.school_terms group by academic_year
                ) a where '$date' between start_date and end_date;
            ";
            $term = DB::select( $sql );
            if (isset($term[0])) {
                $start_date = $term[0]->start_date;
                $term = $term[0];
            }
        }

        if( $start_date ){
            $term->{'weeks'} = datediff( 'ww', $start_date, $date );
            $term->{'name'}  = $term->academic_year . '-' . ($term->academic_year+1-2000) .' '. $term->term .' ( Week '.$term->weeks.' )';
            $term->{'date'}  = $date;
        }
        else{
            $term = [
                'name' => '(Not available)',
                'date' => $date
            ];
        }
        
        return $term;
    }

    function generate_cols()
    {
        $cols = RegisterColumn::all();
    }
}
