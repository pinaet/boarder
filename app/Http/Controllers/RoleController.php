<?php

namespace App\Http\Controllers;

use App\Models\PermissionContent;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function role_save()
    {    
        $user        = auth()->user();
        $c_role      = request()->c_role;
        
        $role        = Role::find($c_role['id']);
        $attribuites = [
            'role_name'  => $c_role['role_name'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        if( $role ){
            $role->update( $attribuites );
        }
        else{
            $role   = Role::create( $attribuites );
        }

        //set or update user role
        foreach( $c_role['contents'] as $role_content ){
            if( $role_content['enabled'] ){
                RolePermission::updateOrCreate(
                    [   //where
                        'role_id'               => $role['id'],
                        'permission_content_id' => $role_content['content_id'],
                    ],
                    [   //what to update
                        'permission' => 'update',
                    ]
                );
            }
            else{
                $result = RolePermission::where('role_id',$role->id)->where('permission_content_id',$role_content['content_id'])->first();
                if( $result ){
                    $result->delete();
                }
            }
        }
        
        $contents = PermissionContent::all();
        $role     = $role->refine_role( $role, $contents );

        $data = [
            'role'   => $role,
            'message' => 'OK 200 - role save'
        ];

        return $data;
    }

    function role_delete()
    {
        $c_role = request()->c_role;

        RolePermission::where('role_id', $c_role['id'])->delete();
        Role::where('id', $c_role['id'])->delete();

        $data = [
            'role'   => $c_role,
            'message' => 'OK 200 - role delete'
        ];

        return $data;
    }  

}
