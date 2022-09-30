<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        $role = $user->role;
        dd($user,$user->role,$role[0]->permission_contents);
        
        $role = Role::find(1);
        dd($role,$role->permission_contents);
    }
}
