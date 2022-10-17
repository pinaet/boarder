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
        Schema::create('school_terms', function (Blueprint $table) {
            $table->id();
            $table->integer('academic_year');
            $table->string('term');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('school_terms');
    }


    public function generate()
    {
        (new SyncController)->syncSchoolTerms();
    }
};
