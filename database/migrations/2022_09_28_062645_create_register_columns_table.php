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
        //Monday
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Tuesday
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Wednesday
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Thursday
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Friday
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Saturday
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = '1000';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = '1300';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = '1600';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = '1800';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        
        //Saturday
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = '1100';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = '1300';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = '1600';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = '2000';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        RegisterColumn::create($attributes);
    }
};
