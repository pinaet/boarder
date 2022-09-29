<?php

use App\Models\PermissionContent;
use App\Models\RolePermission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained();
            $table->foreignId('permission_content_id')->constrained();
            $table->string('permission'); //v,u,d
            $table->timestamps();
        });

        $this->generate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('role_permissions', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'role_id',
        //         'permission_content_id'                
        //     ]);
        // });
        Schema::dropIfExists('role_permissions');
    }


    public function generate()
    {
        $permission_contents = PermissionContent::all();
        foreach( $permission_contents as $permission_content ) {
            $role_permission = [
                'role_id' => 1,
                'permission_content_id' => $permission_content->id,
                'permission' => 'update'
            ];
            RolePermission::create($role_permission);
        }
    }
};
