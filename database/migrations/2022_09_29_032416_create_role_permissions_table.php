<?php

use App\Models\Building;
use App\Models\RolePermission;
use App\Models\PermissionContent;
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
        $this->down();
        
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained();
            $table->foreignId('permission_content_id')->constrained();
            $table->string('permission')->nullable(); //v,u,d
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

        $buildings = Building::all();
        foreach( $buildings as $building ) {
            $role_permission = [
                'role_id' => 2,
                'permission_content_id' => $building->id,
                'permission' => 'update'
            ];
            RolePermission::create($role_permission);
        }
    }
};
