<?php

use App\Models\UserRole;
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

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('role_id')->constrained();
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
        // Schema::table('user_roles', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'user_id',
        //         'role_id',
        //         'created_by',
        //         'updated_by'                
        //     ]);
        // });
        Schema::dropIfExists('user_roles');
    }


    public function generate()
    {
        $attributes['user_id']    = 1;       
        $attributes['role_id']    = 1;   
        $attributes['created_by'] = 1;       
        $attributes['updated_by'] = 1;
        UserRole::create($attributes);
    }
};
