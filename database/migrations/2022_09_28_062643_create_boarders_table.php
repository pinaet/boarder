<?php

use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\SyncController;
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
        Schema::create('boarders', function (Blueprint $table) {
            $table->string('pupil_id')->unique();
            $table->foreignId('building_id')->constrained();
            $table->string('offsite_permission')->nullable();
            $table->string('telephone')->nullable(); //m,f
            $table->integer('admission_no')->nullable();
            $table->string('prefered_forename'); 
            $table->string('forename'); 
            $table->string('surname'); 
            $table->string('year_group'); 
            $table->string('house'); 
            $table->string('form'); 
            $table->string('gender'); 
            $table->string('boarder_type')->nullable(); 
            $table->binary('photo')->nullable(); 
            $table->string('status')->nullable(); 
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
        Schema::dropIfExists('boarders');
        // Schema::table('boarders', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'building_id',
        //         'updated_by',
        //     ]);
        // });
    }


    public function generate()
    {
        (new SyncController)->syncBoarders();
    }
};
