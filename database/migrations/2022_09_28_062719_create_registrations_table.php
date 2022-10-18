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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('pupil_id');
            $table->foreign('pupil_id')->references('pupil_id')->on('boarders');
            $table->foreignId('attendance_id')->constrained();
            $table->foreignId('register_column_id')->constrained();//->references('id')->on('register_columns');
            $table->string('date');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->references('id')->on('users');
            $table->string('year_group'); //Y5,Y6
            $table->integer('academic_year');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('registrations');
        // Schema::table('registrations', function (Blueprint $table) {
        //     $table->dropForeign([
        //         'pupil_id',
        //         'attendance_id',
        //         'register_column_id',
        //         'created_by',
        //         'updated_by'
        //     ]);
        // });
    }
};
