<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use Illuminate\Http\Request;

class BoarderController extends Controller
{
    public function dashboard()
    {
        // dd( Building::all() );
        $boarders = Boarder::where('status','Current')->orderBy('prefered_forename')->take(3)->get();
        $boarders = $this->prepare_boarders( $boarders );
        $attendances = Attendance::all();
        $buildings = Building::all();

        // $building = 'West Acre';
        return Inertia::render('Dashboard', [
            'all_boarders'  => $boarders,
            'attendances'   => $attendances,
            'buildings'     => $buildings,
        ]);
    }

    function update_profile()
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

    function change_building()
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
}
