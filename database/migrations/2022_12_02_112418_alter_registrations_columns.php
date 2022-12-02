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
        Schema::table('registrations', function (Blueprint $table) {
            $table->renameColumn('created_by', 'registered_by');
            $table->renameColumn('updated_by', 'noted_by'     );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->renameColumn('registered_by', 'created_by');
            $table->renameColumn('noted_by'     , 'updated_by');
        });
    }
};
