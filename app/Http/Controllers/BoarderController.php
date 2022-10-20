<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use App\Models\Attendance;
use App\Models\SchoolTerm;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\RegisterColumn;
use Exception;
use Illuminate\Support\Facades\DB;

class BoarderController extends Controller
{
    public function dashboard()
    {
        $attendances = Attendance::all();
        $buildings   = Building::all();

        $dates       = $this->generate_dates();
        $term        = $this->generate_term();
        $headers     = $this->generate_cols( $dates );
        // dd($headers);
        $boarders    = Boarder::where('status','Current')->orderBy('prefered_forename')->take(4)->get();
        $data        = $this->prepare_boarders( $boarders );
        $boarders    = $data[ 'boarders' ];
        $totals      = $data[ 'totals'   ];

        // $building = 'West Acre';
        return Inertia::render('Dashboard', [
            'all_boarders'  => $boarders,
            'attendances'   => $attendances,
            'buildings'     => $buildings,
            'dates'         => $dates,
            'term'          => $term,
            'headers'       => $headers,
            'totals'        => $totals,
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
        $dates    = $this->generate_dates();
        $temp     = $this->prepare_boarders( $boarders, $dates[0]['date'] );
        $boarders = $temp['boarders'];

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

    public function store_attendance()
    {
        /**
         * Undocumented function
         *
            pupil_id
            attendance_id
            register_column_id
            date
            created_by
            updated_by
            year_group
            academic_year
            notes
         */
        $attendance_id      = request()->attendance_id;
        $pupil_id           = request()->pupil_id;
        $register_column_id = request()->register_column_id;
        $date               = request()->date;
        $academic_year      = request()->academic_year;
        $notes              = request()->notes;
        
        $boarder  = Boarder::where('pupil_id',$pupil_id)->first();

        // $register = Registration::where('pupil_id',$pupil_id)->where('register_column_id',$register_column_id)->where('date',$date)->where('date',$date)->get();
        $register = Registration::updateOrCreate(
            [   //where
                'pupil_id'           => $pupil_id,
                'register_column_id' => $register_column_id,
                'date'               => $date,
            ],
            [
                'attendance_id' => $attendance_id,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id,
                'year_group'    => $boarder->year_group,
                'academic_year' => $academic_year,
                'notes'         => $notes,
            ] //what to update
        );

        $data = [
            'register'=> $register,
            'message' => 'OK 200 - store attendance'
        ];
        return $data;
    }

    function prepare_boarders( $boarders, $seed_date='' )
    {
        if( $seed_date=='' ){
            $seed_date = date('Y-m-d');
        }
        
        $attendance  = Attendance::where( 'is_default', 1 )->first();
        $dates       = $this->generate_dates( $seed_date );
        $term        = $this->generate_term(  $seed_date );
        $headers     = $this->generate_cols(  $dates     );

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

            //prepare boarder registrations
            $start_date    = $dates[0]['formatted'];
            $end_date      = $dates[6]['formatted'];
            
            $registrations = Registration::where('date','>=',$start_date)->where('date','<=',$end_date)->get();

            $registers     = [];
            foreach( $headers['cols'] as $header )
            {
                foreach( $header['cols'] as $col )
                {
                    $register = [];
                    foreach( $registrations as $reg )
                    {
                        if( $col->id==$reg->register_column_id && $reg->date==$header['date'] && $reg->pupil_id==$boarder->pupil_id){
                            //assign register value
                            // dd($boarder,$header,$col,$reg,$attendance);
                            $register = [
                                'pupil_id'           => $boarder->pupil_id,
                                'register_column_id' => $col->id,
                                'attendance_id'      => $reg->attendance_id,
                                'width'              => $col->width,
                                'notes'              => $reg->notes,
                                'date'               => $reg->date,
                                'academic_year'      => $term->academic_year,
                                'status'             => $header['status'],
                            ];

                            break;
                        }
                    }

                    if( !$register ){
                        if( $col->width==config('app.width') )
                        {
                            $register = [
                                'pupil_id'           => $boarder->pupil_id,
                                'register_column_id' => $col->id,
                                'attendance_id'      => $attendance->id,
                                'width'              => $col->width,
                                'notes'              => '',
                                'date'               => $header['date'],
                                'academic_year'      => $term->academic_year,
                                'status'             => $header['status'],
                            ];
                        }
                        else
                        {   
                            //prepare attendance from mis
                            //mis attendance data
                            $register = [
                                'pupil_id'           => $boarder->pupil_id,
                                'register_column_id' => $col->id,
                                'attendance_id'      => 0,
                                'width'              => $col->width,
                                'notes'              => '/',
                                'date'               => $header['date'],
                                'academic_year'      => $term->academic_year,
                                'status'             => $header['status'],
                            ];
                        }
                    }

                    array_push( $registers, $register );
                }
            }

            $boarder->{'registers'}     = $registers;
        }

        $totals      = [];
        $attendances = Attendance::all();
        $reg_cols    = RegisterColumn::all();
        foreach( $attendances as $attendance )
        {
            $totals[$attendance->id] = [];
            foreach( $reg_cols as $reg_col )
            {
                $totals[$attendance->id][$reg_col->id] = [];
                $totals[$attendance->id][$reg_col->id][config('app.width')] = [];
                foreach( $dates as $date )
                {
                    $totals[$attendance->id][$reg_col->id][config('app.width')][$date['formatted']] = 0;
                }
            }
        }
        foreach( $boarders as $boarder )
        {
            foreach( $boarder->registers as $register )
            {
                try {
                    if( $register['width']==config('app.width')){
                        $totals[ $register['attendance_id'] ][ $register['register_column_id'] ][ $register['width'] ][ $register['date'] ] ++;
                    }
                } catch (Exception $e) {
                    dd($e,$register);
                }
            }
        }
        
        $data = [
            'boarders'  => $boarders,
            'totals'    => $totals,
        ];

        return $data;
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
        // Ref. https://www.php.net/manual/en/datetime.format.php

        $dates = array();
        $week_days = [
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
        ];
        $day_colors = [
            //'bg-yellow-100', 'bg-pink-100', 'bg-green-100', 'bg-orange-100', 'bg-blue-100', 'bg-purple-100', 'bg-red-100'
            '#FEF9C3'        , '#FCE7F3'    , '#DCFCE7'     , '#FFEDD5'      , '#DBEAFE'    , '#F3E8FF'      , '#FEE2E2'
        ];

        $date = array();

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
                }
                $status = 'current';
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
                'color'      => $day_colors[ $index ]
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

    function generate_cols( $dates )
    {
        $reg_cols   = RegisterColumn::all();
        $min_w      = 0;
        $max_w      = 0;
        $group      = 1;
        $colspan    = 0;
        $cols       = [];
        $temp_cols  = [];
        $sub_max_w  = 0;
        $sub_min_w  = 0;
        foreach( $reg_cols as $i => $reg_col )
        {
            if( $reg_col->day_of_week==$group ){
                array_push( $temp_cols, $reg_col );
            }
            
            if( $reg_col->day_of_week!=$group || count($reg_cols)==$i+1 ){
                // dd($i,$sub_min_w,$sub_max_w,$temp_cols);
                if( count($reg_cols)==$i+1 ){
                    $sub_max_w  += $reg_col->width;
                    if( $reg_col->width==82 ){
                        $sub_min_w  += $reg_col->width;
                    }
                }
                $temp = [
                    'id'        => $group,
                    'col_name'  => $dates[$group-1]['day'] .' ( '. $dates[$group-1]['date_short'] .' )',
                    'colspan'   => $colspan,
                    'cols'      => $temp_cols,
                    'max_w'     => $sub_max_w,
                    'min_w'     => $sub_min_w,
                    'status'    => $dates[$group-1]['status'],
                    'color'     => $dates[$group-1]['color'],
                    'date'      => $dates[$group-1]['formatted']
                ];
                array_push( $cols, $temp );

                $group      = $reg_col->day_of_week;
                $colspan    = 0;
                $sub_max_w  = 0;
                $sub_min_w  = 0;
                $temp_cols  = [];

                array_push( $temp_cols, $reg_col );
            }

            $max_w      += $reg_col->width;
            $sub_max_w  += $reg_col->width;
            if( $reg_col->width==82 ){
                $min_w      += $reg_col->width;
                $sub_min_w  += $reg_col->width;
            }
            
            $colspan++;
        }

        $headers = [
            'cols'  => $cols,
            'min_w' => $min_w,
            'max_w' => $max_w,
        ];
        
        return $headers;
    }
}
