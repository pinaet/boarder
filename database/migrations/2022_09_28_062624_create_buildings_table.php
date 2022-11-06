<?php

use App\Models\Building;
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
        $this->down();
        
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('building_name');
            $table->string('description');
            $table->string('member_gender'); //m,f
            $table->string('member_year_group'); //Y5,Y6
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
        Schema::dropIfExists('buildings');
    }


    public function generate()
    {
        $attributes['building_name']     = 'Bradbys';       
        $attributes['description']       = 'Bradbys';   
        $attributes['member_gender']     = 'M';       
        $attributes['member_year_group'] = 'Y4,Y5,Y6,Y7,Y8,Y9,10';
        Building::create($attributes);
        
        $attributes['building_name']     = 'Junior Girls';       
        $attributes['description']       = 'Junior Girls';   
        $attributes['member_gender']     = 'F';       
        $attributes['member_year_group'] = 'Y4,Y5,Y6,Y7,Y8,Y9';
        Building::create($attributes);
        
        $attributes['building_name']     = 'The Grove';       
        $attributes['description']       = 'The Grove';   
        $attributes['member_gender']     = 'M';       
        $attributes['member_year_group'] = '11,12,13';
        Building::create($attributes);
        
        $attributes['building_name']     = 'West Acre';       
        $attributes['description']       = 'West Acre';   
        $attributes['member_gender']     = 'F';       
        $attributes['member_year_group'] = '10,11,12,13';
        Building::create($attributes);
    }
};
