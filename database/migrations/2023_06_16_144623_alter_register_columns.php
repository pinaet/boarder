<?php

use App\Models\RegisterColumn;
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
        Schema::table('register_columns', function (Blueprint $table) {
            $table->date('start_date')->nullable(); //start_date must be Monday only!
        });        

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['register_column_id']);
        });

        (new RegisterColumn)->generate_2023();

        Schema::table('registrations', function (Blueprint $table) {
            $table->foreign('register_column_id')->references('id')->on('register_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_columns', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['register_column_id']);
        });

        (new RegisterColumn)->generate();

        Schema::table('registrations', function (Blueprint $table) {
            $table->foreign('register_column_id')->references('id')->on('register_columns');
        });
    }
};
