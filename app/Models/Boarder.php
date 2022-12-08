<?php

namespace App\Models;

use App\Models\Contact;
use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boarder extends Model
{
    use HasFactory;

    protected $guarded      = [];

    protected $primaryKey   = 'pupil_id';

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function building()
    {
        return $this->hasOne(Building::class, 'id', 'building_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'pupil_id', 'pupil_id');
    }

    public function year_groups()
    {
        return $this->belongsTo(YearGroup::class, 'year_group', 'year_group');
    }


    

    function get_boarders_by_building( $building_name )
    {
        if( env('APP_ENV')=='production'){
            if( $building_name=='All' )
            {
                $boarders = Boarder::where( 'status', 'Current' )
                                    ->where( 'boarder_type', '<>', 'Not a boarder' )
                                    ->where( 'boarder_type', '<>', '' )
                                    ->join( 'year_groups', 'year_groups.year_group', '=', 'boarders.year_group')
                                    ->orderBy( 'building_id' )
                                    ->orderBy( 'year_groups.display_order' )
                                    ->orderBy( 'prefered_forename' )->get();
            }
            else
            {
                $building = Building::where('building_name', $building_name)->first();
                $boarders = Boarder::where( 'status', 'Current' )
                                    ->where( 'boarder_type', '<>', 'Not a boarder' )
                                    ->where( 'boarder_type', '<>', '' )
                                    ->where( 'building_id', $building->id )
                                    ->join( 'year_groups', 'year_groups.year_group', '=', 'boarders.year_group')
                                    ->orderBy( 'building_id' )
                                    ->orderBy( 'year_groups.display_order' )
                                    ->orderBy( 'prefered_forename' )->get();
            }
        }
        else{
            if( $building_name=='All' )
            {
                $boarders = Boarder::where( 'status', 'Current' )
                                    ->where( 'boarder_type', '<>', 'Not a boarder' )
                                    ->where( 'boarder_type', '<>', '' )
                                    ->join( 'year_groups', 'year_groups.year_group', '=', 'boarders.year_group')
                                    ->orderBy( 'building_id' )
                                    ->orderBy( 'year_groups.display_order' )
                                    ->orderBy( 'prefered_forename' )->take( env('BOARDER_SIZE',5) )->get();
            }
            else
            {
                $building = Building::where('building_name', $building_name)->first();
                $boarders = Boarder::where( 'status', 'Current' )
                                    ->where( 'boarder_type', '<>', 'Not a boarder' )
                                    ->where( 'boarder_type', '<>', '' )
                                    ->where( 'building_id', $building->id )
                                    ->join( 'year_groups', 'year_groups.year_group', '=', 'boarders.year_group')
                                    ->orderBy( 'building_id' )
                                    ->orderBy( 'year_groups.display_order' )
                                    ->orderBy( 'prefered_forename' )->take( env('BOARDER_SIZE',5) )->get();
            }
        }

        return $boarders;
    }
}
