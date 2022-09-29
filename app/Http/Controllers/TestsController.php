<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function index()
    {
        
        $contents = array(
            'Bradbys',
            'Junior Girls',
            'The Grove',
            'West Acre',
        );

        foreach ($contents as $content) {
            $my_array = ['permission_content_name'=>$content];
        }
        dd($my_array);
    }
}
