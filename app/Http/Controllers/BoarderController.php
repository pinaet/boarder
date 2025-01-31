<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use App\Models\Attendance;
use App\Models\SchoolTerm;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\RegisterColumn;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PaperformController;
use App\Models\PermissionContent;

class BoarderController extends Controller
{
    public function dashboard()
    {
        $attendances      = Attendance::all();
        $buildings        = Building::all();
        $building_permits = (new Building)->get_bulding_permits();

        /*
        * check if user has access to any boarding house
        */
        if( count($building_permits)<1 ){
            Auth::logout( auth()->user() );
            $message = "
                Sorry, you don't have to any boarding house
            ";
            return Inertia::render('Login/Error', [
                'title' => 'No boarding house to access',
                'message' => $message,
                'url' => url('/login'),
                'type' => 'danger'
            ]);
        }
    
        /*
        * assign building_name for the user with the least boarders num
        */
        $building_name    = '';
        //take last visit building for the current user - login as?
        if(!auth()->user()->last_visit){
            $building_name= $building_permits[0]=='All'? $building_permits[1] : $building_permits[0];
            auth()->user()->last_visit = $building_name;
            auth()->user()->save();
        }
        else{
            $building_name= auth()->user()->last_visit;
        }
        $boarders         = (new Boarder)->get_boarders_by_building( $building_name );
        
        $data             = $this->prepare_boarders( $boarders, '' );
        $boarders         = $data[ 'boarders' ];
        $totals           = $data[ 'totals'   ];
        $dates            = $data[ 'dates'    ];
        $term             = $data[ 'term'     ];
        $headers          = $data[ 'headers'  ];

        /*
        * get settings permission
        */
        $setting_permits  = (new PermissionContent)->get_setting_permissions();

        return Inertia::render('Dashboard', [
            'boarders'          => $boarders,
            'attendances'       => $attendances,
            'buildings'         => $buildings,
            'dates'             => $dates,
            'term'              => $term,
            'headers'           => $headers,
            'totals'            => $totals,
            'building_name'     => $building_name,
            'building_permits'  => $building_permits,
            'setting_permits'   => $setting_permits,
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
        $building_name  = request()->building_name;
        $dates          = request()->dates;
        $weekly         = request()->weekly;
        $seed_date      = '';//dd($building_name,$dates,$weekly);

        foreach( $dates as $date ){
            if( $date['status']=='current' ){
                $seed_date = $date['formatted'];
                break;
            }
        }
        if( !$seed_date ){
            $seed_date = $dates[0]['formatted'];
        }
        if( !$weekly ){
            $seed_date = date('Y-m-d');
        }

        $boarders = (new Boarder)->get_boarders_by_building( $building_name );

        //'boarders','dates','term','headers','totals' --> boarders, registers, totals
        $temp     = $this->prepare_boarders( $boarders, $seed_date, $weekly );
        $boarders = $temp[ 'boarders' ];
        $totals   = $temp[ 'totals'   ];
        $dates    = $temp[ 'dates'    ];
        $term     = $temp[ 'term'     ];
        $headers  = $temp[ 'headers'  ];

        $data = [
            'boarders' => json_decode(json_encode($boarders)),
            'dates'    => $dates,
            'term'     => $term,
            'headers'  => $headers,
            'totals'   => $totals,
            'message'  => 'OK 200 - change_building',
        ];

        /* remember last visit building for the current user */
        auth()->user()->last_visit = $building_name;
        auth()->user()->save();
        
        return $data;
    }

    public function change_week()
    {
        $term          = request()->term;
        $direction     = request()->direction;
        $building_name = request()->building_name;
        $weekly        = request()->weekly;

        $word          = '';

        if( $direction=='previous' )
        {
            $word      = '-1 week';
        }
        else
        {
            $word      = '+1 week';
        }
        // dd( $direction, $term );

        $seed_date  = date( 'Y-m-d', strtotime( $word . ' ' . $term['date'] ) );
        
        $boarders   = (new Boarder)->get_boarders_by_building( $building_name );
        $temp       = $this->prepare_boarders( $boarders, $seed_date, $weekly );
        $boarders   = $temp[ 'boarders' ];
        $totals     = $temp[ 'totals'   ];
        $dates      = $temp[ 'dates'    ];
        $term       = $temp[ 'term'     ];
        $headers    = $temp[ 'headers'  ];

        $data = [
            'boarders' => json_decode(json_encode( $boarders )),
            'dates'    => $dates,
            'term'     => $term,
            'headers'  => $headers,
            'totals'   => $totals,
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
            registered_by
            noted_by
            year_group
            academic_year
            notes

            store_type = register or note
         */
        $attendance_id      = request()->attendance_id;
        $pupil_id           = request()->pupil_id;
        $register_column_id = request()->register_column_id;
        $date               = request()->date;
        $academic_year      = request()->academic_year;
        $notes              = request()->notes;

        $store_type         = request()->store_type;
        
        $boarder            = Boarder::where('pupil_id',$pupil_id)->first();

        $register_old       = Registration::where('pupil_id',$pupil_id)->where('register_column_id',$register_column_id)->where('date',$date)->first();
        if( $store_type=='register' )
        {   //register
            $register = Registration::updateOrCreate(
                [   //where
                    'pupil_id'           => $pupil_id,
                    'register_column_id' => $register_column_id,
                    'date'               => $date,
                ],
                [
                    'attendance_id' => $attendance_id,
                    'year_group'    => $boarder->year_group,
                    'academic_year' => $academic_year,
                    'notes'         => $notes,
                    'noted_by'      => isset($register_old) ? $register_old->noted_by : 0,
                    'registered_by' => auth()->user()->id,
                ] //what to update
            );
        }
        else
        {   //note
            $register = Registration::updateOrCreate(
                [   //where
                    'pupil_id'           => $pupil_id,
                    'register_column_id' => $register_column_id,
                    'date'               => $date,
                ],
                [
                    'attendance_id' => $attendance_id,
                    'year_group'    => $boarder->year_group,
                    'academic_year' => $academic_year,
                    'notes'         => $notes,
                    'noted_by'      => auth()->user()->id,
                    'registered_by' => isset($register_old) ? $register_old->registered_by : 0,
                ] //what to update
            );
        }

        $data = [
            'register'=> $register,
            'message' => 'OK 200 - store attendance'
        ];
        return $data;
    }

    function prepare_boarders($boarders, $seed_date = '', $weekly = false)
    {
        $seed_date      = $seed_date ?: date('Y-m-d');
        
        $attendance     = Attendance::where('is_default', 1)->first();
        $dates          = $this->generate_dates($seed_date, $weekly);
        $term           = $this->generate_term($seed_date);
        $headers        = $this->generate_cols($dates, $weekly);

        $dateRange      = $this->getDateRange($dates, $weekly);
        $pupilIds       = $boarders->pluck('pupil_id');
        $registrations  = Registration::whereIn('pupil_id', $pupilIds)
                                    ->whereBetween('date', $dateRange)
                                    ->get()
                                    ->groupBy('pupil_id');

        $boarders->map(function ($boarder) use ($registrations, $headers, $attendance, $term) {
            $boarder->photo               = base64_encode($boarder->photo);
            $boarder->building_name       = $boarder->building->building_name ?? '-';
            $boarder->contacts            = $boarder->contacts ?? [];
            $boarder->registers           = $this->prepareBoarderRegisters($boarder, $registrations[$boarder->pupil_id] ?? collect(), $headers, $attendance, $term);
            $boarder->absence_request_url = (new PaperformController)->paperform('leave-request-form', $boarder);
            return $boarder;
        });

        $totals         = $this->prepareTotals($boarders, $dates, $attendance);

        return [
            'boarders'  => $boarders,
            'totals'    => $totals,
            'dates'     => $dates,
            'term'      => $term,
            'headers'   => $headers,
        ];
    }

    protected function getDateRange($dates, $weekly)
    {
        if ($weekly) {
            return [$dates[0]['formatted'], $dates[6]['formatted']];
        }

        return [$dates[0]['formatted'], $dates[0]['formatted']];
    }

    protected function prepareBoarderRegisters($boarder, $registrations, $headers, $attendance, $term)
    {
        $registers          = [];
        foreach ($headers['cols'] as $header) {
            foreach ($header['cols'] as $col) {
                $reg = $registrations->first(function ($registration) use ($col, $header) {
                    return $registration->register_column_id == $col->id && $registration->date == $header['date'];
                });

                $register   = $reg ? $this->buildRegisterFromReg($boarder, $col, $reg, $term, $header) : 
                                $this->buildDefaultRegister($boarder, $col, $attendance, $term, $header);

                $registers[]= $register;
            }
        }

        return $registers;
    }

    protected function buildRegisterFromReg($boarder, $col, $reg, $term, $header)
    {
        return [
            'pupil_id'          => $boarder->pupil_id,
            'register_column_id'=> $col->id,
            'attendance_id'     => $reg->attendance_id,
            'width'             => $col->width,
            'notes'             => $reg->notes,
            'date'              => $reg->date,
            'academic_year'     => $term->academic_year,
            'status'            => $header['status'],
            'registered_by'     => $reg->registered_by_user->username ?? '-',
            'noted_by'          => $reg->noted_by_user->username ?? '-',
        ];
    }

    protected function buildDefaultRegister($boarder, $col, $attendance, $term, $header)
    {
        return [
            'pupil_id'          => $boarder->pupil_id,
            'register_column_id'=> $col->id,
            'attendance_id'     => $col->width == config('app.width') ? $attendance->id : 0,
            'width'             => $col->width,
            'notes'             => '',
            'date'              => $header['date'],
            'academic_year'     => $term->academic_year,
            'status'            => $header['status'],
            'registered_by'     => '-',
            'noted_by'          => '-',
        ];
    }

    protected function prepareTotals($boarders, $dates, $attendance)
    {
        $totals = [];
        // Your logic to prepare totals goes here, optimized similarly using collections and efficient loops
        $widthConfig = config('app.width');
        $attendances = Attendance::all();
        $reg_cols    = RegisterColumn::all();
        for( $i=0;$i<=count($attendances);$i++ ){
            $totals[$i] = [];
            for( $j=0;$j<=count($reg_cols);$j++ ){
                $totals[$i][$j] = [];
                for( $k=0;$k<=$widthConfig;$k++ ) {
                    $totals[$i][$j][$k] = [];
                }
            }
        }
        foreach( $attendances as $attendance )
        {
            foreach( $reg_cols as $reg_col )
            {
                foreach( $dates as $date )
                {
                    $totals[$attendance->id][$reg_col->id][$reg_col->width][$date['formatted']] = 0;
                }
            }
        }
        foreach( $boarders as $boarder )
        {
            foreach( $boarder->registers as $register )
            {
                try {
                    if( $register['width']==$widthConfig){
                        $totals[ $register['attendance_id'] ][ $register['register_column_id'] ][ $register['width'] ][ $register['date'] ] ++;
                    }
                } catch (Exception $e) {
                    dd($e,$register);
                }
            }
        }

        return $totals;
    }

    function generate_dates( $seed_date='', $weekly=false )
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

        if( $weekly )
        {
            /*
                weekly
            */
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
                    if( $temp==date( 'Y-m-d' ) ){
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
                    'color'      => $day_colors[ $index ]
                );
    
                array_push( $dates, $date );
            }
        }
        else
        {
            /*
                today
            */
            //current date
            $order = date( 'N' ) - 1;
            $day   = date( 'l' );

            foreach( $week_days as $index => $value )
            {
                if( $value==$day )
                {
                    $temp   = date( 'Y-m-d' );
                    $status = 'current';
        
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
                    break;
                }
            }
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
                    select academic_year, '-' term, min(start_date) start_date, max(end_date) end_date from school_terms group by academic_year
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
            $term = collect([
                (object) [
                    'name' => '(Not available)',
                    'date' => $date,
                    'academic_year' => 0
                ]
            ])[0];
        }
        
        return $term;
    }

    function generate_cols( $dates, $weekly=false )
    {
        //get register column start date
        $start_date = (new RegisterColumn)->get_start_date( $dates, $weekly );

        if( $weekly ){
            //weekly
            $reg_cols   = RegisterColumn::where('start_date',$start_date)->get();
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
        }
        else{
            //today
            $reg_cols   = RegisterColumn::where('start_date',$start_date)->where('day_of_week', date('N'))->get();
            $min_w      = 0;
            $max_w      = 0;
            $group      = date('N');
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
    
                $max_w      += $reg_col->width;
                $sub_max_w  += $reg_col->width;
                if( $reg_col->width==82 ){
                    $min_w      += $reg_col->width;
                    $sub_min_w  += $reg_col->width;
                }
                
                $colspan++;
            }
            $temp = [
                'id'        => $group,
                'col_name'  => $dates[0]['day'] .' ( '. $dates[0]['date_short'] .' )',
                'colspan'   => $colspan,
                'cols'      => $temp_cols,
                'max_w'     => $sub_max_w,
                'min_w'     => $sub_min_w,
                'status'    => $dates[0]['status'],
                'color'     => $dates[0]['color'],
                'date'      => $dates[0]['formatted']
            ];
            array_push( $cols, $temp );
        }

        $headers = [
            'cols'  => $cols,
            'min_w' => $min_w,
            'max_w' => $max_w,
        ];
        
        return $headers;
    }
}
