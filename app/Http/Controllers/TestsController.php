<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Models\RegisterColumn;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SyncController;
use App\Models\Boarder;
use App\Models\PermissionContent;
use App\Models\RolePermission;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TestsController extends Controller
{
    public function index()
    {



        /**
         * generate columns
         */
        $start_date = date('Y-m-d', strtotime( '- 3 days' ) );
        (new SyncController)->syncSchoolAttendance( $start_date );//'2022-10-24'
        dd('syncSchoolAttendance: done');





        /**
         * join query
         */
        // select all 'Bradbys/The Grove' boarders to 'The Grove' with conditions year_group in '11,12,13' and gender='M'
        $boarders           = Boarder::join(   'buildings', 'buildings.id', '=', 'boarders.building_id' )
                                     ->where(  'buildings.building_name', 'Bradbys/The Grove')
                                     ->whereIn('boarders.year_group', ['11','12','13'])
                                     ->where(  'buildings.gender', 'M')
                                     ->get();
        dd('join query');



        

        /**
         * update boarder 'status' and 'boarder_type'
            pupil_id
            admission_no
            prefered_forename
            forename
            surname
            year_group
            house
            form
            gender
            boarder_type
            photo
            status
         */
        $boarders     = Boarder::all();
        $all_students = collect(DB::connection('mis')->select( (new SyncController)->getBoarderQuery( 'all') ));
        foreach( $boarders as $boarder )
        {
            $student = $all_students->where('PupilID',$boarder->pupil_id)->first();
            if( $student && ( $boarder->boarder_type != $student->BoarderStatus || $boarder->status != $student->StudentStatus ) )
            {
                $boarder->boarder_type  = $student->BoarderStatus;
                $boarder->status        = $student->StudentStatus;
                $boarder->save();
                dd(2, $boarder, $student);
            }
        }
        dd(1, 'update boarder status and boarder_type');


        /**
         * date
         */
        dd(date('Y-m-d H:i:s'));



        /**
         * generate columns
         */
        (new RegisterColumn)->generate();


        /**
         * test mis connection
         */
        (new SyncController)->syncBoarders();
        dd(1);


        /**
         * test user permission relationshipo
         */
        $user = User::find(1);
        $role = $user->role;
        dd($user,$user->role,$role[0]->permission_contents);
        
        $role = Role::find(1);
        dd($role,$role->permission_contents);
    }
}
