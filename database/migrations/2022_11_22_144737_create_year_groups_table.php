<?php

use App\Models\YearGroup;
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
        Schema::create('year_groups', function (Blueprint $table) {
            $table->string('year_group')->unique();
            $table->integer('display_order');
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
        Schema::dropIfExists('year_groups');
    }

    public function generate()
    {
        $attributes['year_group']    = 'LC';            $attributes['display_order'] = 1;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Creche';        $attributes['display_order'] = 2;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Pre-Nursery';   $attributes['display_order'] = 3;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Nursery';       $attributes['display_order'] = 4;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Reception';     $attributes['display_order'] = 5;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Y1';            $attributes['display_order'] = 6;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Y2';            $attributes['display_order'] = 7;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Y3';            $attributes['display_order'] = 8;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Y4';            $attributes['display_order'] = 9;   YearGroup::create( $attributes );
        $attributes['year_group']    = 'Y5';            $attributes['display_order'] = 10;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = 'Y6';            $attributes['display_order'] = 11;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = 'Y7';            $attributes['display_order'] = 12;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = 'Y8';            $attributes['display_order'] = 13;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = 'Y9';            $attributes['display_order'] = 14;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = '10';            $attributes['display_order'] = 15;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = '11';            $attributes['display_order'] = 16;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = '12';            $attributes['display_order'] = 17;  YearGroup::create( $attributes ); 
        $attributes['year_group']    = '13';            $attributes['display_order'] = 18;  YearGroup::create( $attributes ); 
    }
};
