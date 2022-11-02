<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionContent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function get_setting_permissions()
    {
        $user       = auth()->user();
        $role       = $user->role[0];
        $buildings  = Building::all();
        
        //remove all boarding house permission contents
        foreach( $role->permission_contents as $i => $permission_content ){
            foreach( $buildings as $building )
            {
                if( $building->building_name==$permission_content->permission_content_name ){
                    $role->permission_contents->forget($i);
                }
            }
        }

        $permission_contents = [];
        foreach( $role->permission_contents as $i => $permission_content ){
            array_push( $permission_contents, $permission_content );
        }

        return $permission_contents;
    }
}
