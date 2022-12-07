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
        DB::beginTransaction();
        try {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('relationship')->nullable()->change();
                $table->string('contact_name')->nullable()->change();
            });
        } catch (Exception $e) {
            dd( $e );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();
        try {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('relationship')->change();
                $table->string('contact_name')->change();
            });
        } catch (Exception $e) {
            dd( $e );
        }
    }
};
