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
        $buildings   = $this->all();
        $length      = count($buildings);
        $buildings_u = [];

        //get list of allowed content
        foreach( $user->role[0]->permission_contents as $permission_content )
        {
            foreach( $buildings as $j => $building )
            {
                if( $building->building_name==$permission_content->permission_content_name ){
                    array_push( $buildings_u, $building->building_name );
                    //cut
                    $buildings->forget($j);
                }
            }
        }

        if( count($buildings_u)==$length ){
            array_unshift( $buildings_u, 'All' );//insert to the beginning of array
        }

        return $buildings_u;
    }
}
