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

class TestsController extends Controller
{
    public function index()
    {
        /**
         * generate columns
         */
        (new SyncController)->syncSchoolAttendance('2022-10-24');
        dd('syncSchoolAttendance: done');




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
