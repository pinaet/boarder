<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\UserRole;
use App\Models\BlockedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PermissionContent;
use App\Models\RolePermission;

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
            //a user must have at least one role to access the system
            $admin->{'role_name'}       = '';
            foreach ($admin->role as $role) {
                // dd( $admin->role, $role, $admin->{'role_name'} );
                $admin->{'role_name'}   = $role->role_name;
            }
            $admin->{'is_blocked'}      = $admin->blocked ? true : false;
        }

        
        return Inertia::render('Setting/Staff', [
            'setting_permits'   => $setting_permits,
            'admins'            => $admins,
            'roles'             => $roles,
        ]);
    }

    public function role()
    {
        /*
        * get settings permission
        */
        $setting_permits  = (new PermissionContent)->get_setting_permissions();
        $roles            = Role::all();
        $contents         = PermissionContent::all();

        foreach( $roles as $role ){
            $role = $role->refine_role( $role, $contents );
        }
        
        return Inertia::render('Setting/Role', [
            'setting_permits'   => $setting_permits,
            'roles'             => $roles,
            'contents'          => $contents,
        ]);
    }

    public function staff_save()
    {        
        $c_admin = request()->c_admin;
        // $c_admin = json_decode(json_encode(request()->c_admin));//dd($c_admin);

        // $photo   = mb_convert_encoding($c_admin['photo'], 'UTF-8', 'UTF-8');
        
        $admin   = User::updateOrCreate(
            [   //where
                'username'      => $c_admin['username'],
                'email'         => $c_admin['email'],
            ],
            [
                'name'          => $c_admin['name'],
                'telephone'     => $c_admin['telephone'],
                'photo'         => $c_admin['photo'],//base64_decode($photo),//'0x'.base64_decode($c_admin->photo), base64_decode($c_admin['photo'], true) //0x' . bin2hex($boarder->Photo)
                'password'      => Str::random(32),
            ] //what to update
        );

        //set or update user role
        if( $c_admin['role_name'] ){
            $roles = Role::all();
            foreach( $roles as $role ){
                if( $role->role_name==$c_admin['role_name'] ){
                    UserRole::updateOrCreate(
                        [   //where
                            'user_id'    => $admin->id,
                        ],
                        [
                            'role_id'    => $role->id,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                        ] //what to update
                    );
                    break;
                }
            }
        }


        //add or delete blocked user
        if( $c_admin['is_blocked'] ){
            BlockedUser::updateOrCreate(
                [   //where
                    'email' => $c_admin['email'],
                ]
            );
        }
        else{
            BlockedUser::where('email', $c_admin['email'])->delete();
        }


        //a user must have at least one role to access the system
        $admin->{'role_name'}       = '';
        // $admin->photo = base64_encode($admin->photo);//$admin->photo;//
        foreach ($admin->role as $role) {
            // dd( $admin->role, $role, $admin->{'role_name'} );
            $admin->{'role_name'}   = $role->role_name;
        }
        $admin->{'is_blocked'}      = $admin->blocked ? true : false;


        $data = [
            'admin'   => $admin,
            'message' => 'OK 200 - admin save'
        ];

        return $data;
    }

    public function staff_delete()
    {
        $c_admin = request()->c_admin;
        BlockedUser::where('email', $c_admin['email'])->delete();
        UserRole::where('user_id', $c_admin['id'])->delete();
        User::where('id', $c_admin['id'])->delete();

        $data = [
            'admin'   => $c_admin,
            'message' => 'OK 200 - admin delete'
        ];

        return $data;
    }
}
