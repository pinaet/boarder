<?php

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
        Schema::create('boarders', function (Blueprint $table) {
            $table->id();
            $table->string('pupil_id')->unique();
            $table->foreignId('building_id')->constrained();
            $table->string('offsite_permission')->nullable();
            $table->string('telephone')->nullable(); //m,f
            $table->string('status')->nullable(); //Y5,Y6
            $table->foreignId('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boarders');
        // Schema::table('boarders', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'building_id',
        //         'updated_by',
        //     ]);
        // });
    }
};
