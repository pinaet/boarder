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
        Schema::create('register_columns', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week'); //1=Monday 7=Sunday
            $table->integer('display_order');
            $table->string('column_name');
            $table->integer('academic_year');
            $table->integer('width');
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
        Schema::dropIfExists('register_columns');
    }


    public function generate()
    {
        (new RegisterColumn)->generate();
    }
};
