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
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
                $table->renameColumn('created_by', 'registered_by');
                $table->renameColumn('updated_by', 'noted_by'     );
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
            Schema::table('registrations', function (Blueprint $table) {
                $table->renameColumn('registered_by', 'created_by');
                $table->renameColumn('noted_by'     , 'updated_by');
                $table->foreign('created_by')->references('id')->on('users')->change();
                $table->foreign('updated_by')->references('id')->on('users')->change();
            });
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd( $e );
        }
    }
};
