<?php

use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('relationship')->nullable()->change();
                $table->string('contact_name')->nullable()->change();
            });
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd( $e );
        }
    }
};
