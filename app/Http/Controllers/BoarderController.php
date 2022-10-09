<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Boarder;
use App\Models\Building;
use Illuminate\Http\Request;

class BoarderController extends Controller
{
    public function dashboard()
    {
        // dd( Building::all() );
        $boarders = Boarder::where('status','Current')->orderBy('prefered_forename')->take(10)->get();
        // $boarder = Boarder::where('pupil_id','2279')->first(); //dd($boarders,$boarder);
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
            $boarder->{'contacts'} = $boarder->contacts;
            // dd($boarder->contacts,$boarder->building->building_name,$boarder);
        }
        return Inertia::render('Dashboard', [
            'boarders' => $boarders
        ]);
    }
}
