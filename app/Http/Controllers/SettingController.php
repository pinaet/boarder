<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PermissionContent;

class SettingController extends Controller
{
    public function index()
    {
        /*
        * get settings permission
        */
        $setting_permits  = (new PermissionContent)->get_setting_permissions();
        
        return Inertia::render('Setting/Index', [
            'setting_permits'   => $setting_permits,
        ]);
    }

    public function sync()
    {
        $mode       = request()->mode;

        $start_date = '';
        if( $mode=='recent' ){
            $start_date = date('Y-m-d', strtotime( '- 3 days' ) );
        }

        /*
        * sync data from mis
        */
        (new SyncController)->syncBoarders();
        (new SyncController)->syncContacts();
        (new SyncController)->syncSchoolTerms();
        (new SyncController)->syncSchoolAttendance( $start_date );
        

        $data = [
            'message'  => 'OK 200 - sync completed',
        ];
        
        return $data;
    }

    public function staff()
    {
        /*
        * get settings permission
        */
        $setting_permits  = (new PermissionContent)->get_setting_permissions();
        $admins           = User::all();

        foreach( $admins as $admin ){
            //a user must have at least one role to access the system
            $admin->{'role_name'}       = '';
            foreach ($admin->role as $role) {
                $admin->{'role_name'}   = $role->role_name;
            }
            $admin->{'is_blocked'}      = $admin->blocked ? true : false;
            // dd($admin, $admin->role, $admin->blocked);
        }
        
        return Inertia::render('Setting/Staff', [
            'setting_permits'   => $setting_permits,
            'admins'            => $admins,
        ]);
    }
}
