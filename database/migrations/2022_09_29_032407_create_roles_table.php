<?php

use App\Models\Role;
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
        
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->references('id')->on('users');
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
        // Schema::table('roles', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'created_by',
        //         'updated_by'                
        //     ]);
        // });
        Schema::dropIfExists('roles');
    }


    public function generate()
    {     
        $attributes['role_name']  = 'SuperAdmin';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);

        $attributes['role_name']  = 'BoardingStaff';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);

        $attributes['role_name']  = 'Bradbys';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);

        $attributes['role_name']  = 'Junior Girls';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);

        $attributes['role_name']  = 'The Grove';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);

        $attributes['role_name']  = 'West Acre';   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        Role::create($attributes);
    }
};
