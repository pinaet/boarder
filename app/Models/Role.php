<?php

namespace App\Models;

use App\Models\User;
use App\Models\RolePermission;
use App\Models\PermissionContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permission_contents()
    {
        return $this->hasManyThrough(
            PermissionContent::class, 
            RolePermission::class,
            'role_id',
            'id',
            'id',
            'permission_content_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refine_role( $role, $contents )
    {
        $role_contents = [];
        foreach( $contents as $content ){
            $role_permission = RolePermission::where('role_id',$role->id)->where('permission_content_id',$content->id)->first();
            if( $role_permission ){
                $temp = [
                    'content_id'              => $content->id,
                    'enabled'                 => true,
                    'permission_content_name' => $content->permission_content_name,
                    'can_update'              => $role_permission->permission=='update',
                ];
            }
            else{
                $temp = [
                    'content_id'              => $content->id,
                    'enabled'                 => false,
                    'permission_content_name' => $content->permission_content_name,
                    'can_update'              => false,
                ];
            }
            array_push( $role_contents, $temp );
        }
        $role->{'contents'} = $role_contents;
        return $role;
    }
}
