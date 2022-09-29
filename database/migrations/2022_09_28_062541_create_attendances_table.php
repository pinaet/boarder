<?php

use App\Models\Attendance;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('attendance_type_name');
            $table->string('display_symbol');
            $table->boolean('authorised');
            $table->boolean('in_attendance');
            $table->boolean('is_default');
            $table->string('display_colour');
            $table->integer('display_order');
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
        Schema::dropIfExists('attendances');
    }

    public function generate()
    {
        $attributes['attendance_type_name'] = 'No mark recorded';        
        $attributes['display_symbol']       = '-';    
        $attributes['authorised']           = false;
        $attributes['in_attendance']        = false;    
        $attributes['is_default']           = true;
        $attributes['display_colour']       = '#E0E0E0';    
        $attributes['display_order']        = 0;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Present';        
        $attributes['display_symbol']       = '/';    
        $attributes['authorised']           = false;
        $attributes['in_attendance']        = true;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#6FCF97';    
        $attributes['display_order']        = 1;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Absent without permission / Offsite';        
        $attributes['display_symbol']       = 'N';    
        $attributes['authorised']           = false;
        $attributes['in_attendance']        = false;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#FAB1A0';    
        $attributes['display_order']        = 2;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Exeat';        
        $attributes['display_symbol']       = 'E';    
        $attributes['authorised']           = true;
        $attributes['in_attendance']        = false;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#81ECEC';    
        $attributes['display_order']        = 3;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Home';        
        $attributes['display_symbol']       = 'H';    
        $attributes['authorised']           = true;
        $attributes['in_attendance']        = false;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#74B9FF';    
        $attributes['display_order']        = 4;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Sporting or other school commitment';        
        $attributes['display_symbol']       = 'C';    
        $attributes['authorised']           = true;
        $attributes['in_attendance']        = false;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#2D9CDB';    
        $attributes['display_order']        = 5;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Late';        
        $attributes['display_symbol']       = 'L';    
        $attributes['authorised']           = false;
        $attributes['in_attendance']        = true;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#F2994A';    
        $attributes['display_order']        = 6;    
        Attendance::create($attributes);

        $attributes['attendance_type_name'] = 'Isolation / Illness';        
        $attributes['display_symbol']       = 'I';    
        $attributes['authorised']           = false;
        $attributes['in_attendance']        = true;    
        $attributes['is_default']           = false;
        $attributes['display_colour']       = '#F2C94C';    
        $attributes['display_order']        = 6;    
        Attendance::create($attributes);
    }
};
