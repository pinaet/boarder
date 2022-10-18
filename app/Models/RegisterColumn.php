<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterColumn extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function generate()
    {
        
        RegisterColumn::truncate();

        //Monday
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;   
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Morning';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Afternoon';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Reg';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Lesson 1';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 7;   
        $attributes['column_name']   = 'Lesson 2';    
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 8;   
        $attributes['column_name']   = 'Lesson 3';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 9;   
        $attributes['column_name']   = 'Lesson 4';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 10;   
        $attributes['column_name']   = 'Lesson 5';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 11;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 1;       
        $attributes['display_order'] = 12;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Tuesday
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Morning';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Afternoon';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Reg';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Lesson 1';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 7;   
        $attributes['column_name']   = 'Lesson 2';    
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 8;   
        $attributes['column_name']   = 'Lesson 3';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 9;   
        $attributes['column_name']   = 'Lesson 4';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 10;   
        $attributes['column_name']   = 'Lesson 5';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 11;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 2;       
        $attributes['display_order'] = 12;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Wednesday
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Morning';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Afternoon';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Reg';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Lesson 1';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 7;   
        $attributes['column_name']   = 'Lesson 2';    
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 8;   
        $attributes['column_name']   = 'Lesson 3';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 9;   
        $attributes['column_name']   = 'Lesson 4';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 10;   
        $attributes['column_name']   = 'Lesson 5';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 11;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 3;       
        $attributes['display_order'] = 12;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Thursday
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Morning';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Afternoon';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Reg';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Lesson 1';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 7;   
        $attributes['column_name']   = 'Lesson 2';    
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 8;   
        $attributes['column_name']   = 'Lesson 3';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 9;   
        $attributes['column_name']   = 'Lesson 4';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 10;   
        $attributes['column_name']   = 'Lesson 5';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 11;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 4;       
        $attributes['display_order'] = 12;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Friday
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = 'Moning 0715';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = 'Call Over 1740';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = 'Morning';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = 'Afternoon';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Reg';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Lesson 1';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 7;   
        $attributes['column_name']   = 'Lesson 2';    
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 8;   
        $attributes['column_name']   = 'Lesson 3';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 9;   
        $attributes['column_name']   = 'Lesson 4';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 10;   
        $attributes['column_name']   = 'Lesson 5';     
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 25;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 11;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 5;       
        $attributes['display_order'] = 12;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Saturday
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = '1000';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = '1300';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = '1600';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = '1800';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 6;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        
        //Saturday
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 1;   
        $attributes['column_name']   = '1100';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 2;   
        $attributes['column_name']   = '1300';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 3;   
        $attributes['column_name']   = '1600';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 4;   
        $attributes['column_name']   = '2000';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 5;   
        $attributes['column_name']   = 'Bed';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
        $attributes['day_of_week']   = 7;       
        $attributes['display_order'] = 6;   
        $attributes['column_name']   = 'Offsite Status';       
        $attributes['academic_year'] = 2021;
        $attributes['width']         = 82;
        RegisterColumn::create($attributes);
    }
}
