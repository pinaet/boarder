<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\UserRole;
use App\Models\BlockedUser;
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

        /*
        * sync data from mis
        */
        $data = (new SyncController)->syncAll( $mode );

        
        return $data;
    }

    public function staff()
    {
        /*
        * get settings permission
        */
        $setting_permits  = (new PermissionContent)->get_setting_permissions();
        $admins           = User::all();
        $roles            = Role::all();

        foreach( $admins as $admin ){
            $admin->photo = base64_encode($admin->photo);

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
            'roles'             => $roles,
        ]);
    }

    public function staff_save()
    {        
        $c_admin = json_decode(json_encode(request()->c_admin));
        
        $admin   = User::updateOrCreate(
            [   //where
                'username'      => $c_admin->username,
                'email'         => $c_admin->email,
            ],
            [
                'name'          => $c_admin->name,
                'telephone'     => $c_admin->telephone,
                'photo'         => base64_decode($c_admin->photo),
            ] //what to update
        );

        //set or update user role
        if( $c_admin->role_name ){
            $roles = Role::all();
            foreach( $roles as $role ){
                if( $role->role_name==$c_admin->role_name ){
                    UserRole::updateOrCreate(
                        [   //where
                            'user_id' => $c_admin->id,
                        ],
                        [
                            'role_id' => $role->id,
                        ] //what to update
                    );
                    break;
                }
            }
        }

        //add or delete blocked user
        if( $c_admin->is_blocked ){
            BlockedUser::updateOrCreate(
                [   //where
                    'email' => $c_admin->email,
                ]
            );
        }
        else{
            BlockedUser::where('email', $c_admin->email)->delete();
        }

        $admin->photo = base64_encode($admin->photo);
        $data = [
            'admin'   => $admin,
            'message' => 'OK 200 - admin save'
        ];

        return $data;
    }
}
