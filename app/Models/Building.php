<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function get_bulding_permits($user='')
    {
        if(!$user){
            $user    = auth()->user();
        }
        $buildings   = $this->orderBy('building_name')->get();
        $length      = count($buildings);
        $buildings_u = [];

        //get list of allowed content
        foreach( $buildings as $building )
        {
            foreach( $user->role[0]->permission_contents as $j => $permission_content )
            {
                if( $building->building_name==$permission_content->permission_content_name ){
                    array_push( $buildings_u, $building->building_name );
                    //cut
                    $user->role[0]->permission_contents->forget($j);
                }
            }
        }

        if( count($buildings_u)==$length ){
            array_unshift( $buildings_u, 'All' );//insert to the beginning of array
        }

        return $buildings_u;
    }
}
