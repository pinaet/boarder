<?php

use App\Models\PermissionContent;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contents = array(
            'Login As',
        );
        foreach( $contents as $content ) {
            PermissionContent::create(['permission_content_name'=>$content]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permission_content = PermissionContent::where('permission_content_name','Login As')->first();
        if( $permission_content ){
            $permission_content->delete();
        }
    }
};
