<?php

use App\Models\User;
use Illuminate\Support\Str;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('telephone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }

    
    public function generate()
    {
        $attributes['name']     = 'Naet Poonsarakhun';        
        $attributes['email']    = 'naet_ph@harrowschool.ac.th';    
        $attributes['username'] = 'naet_ph';
        $attributes['telephone']= '025037222-1256';
        $attributes['password'] = Str::random(32);
        User::create($attributes);     

        $attributes['name']     = 'Korn Phonlawat';        
        $attributes['email']    = 'korn_ph@harrowschool.ac.th';    
        $attributes['username'] = 'korn_ph';
        $attributes['telephone']= '025037222-1256';
        $attributes['password'] = Str::random(32);
        User::create($attributes);     
        
        $attributes['name']     = 'Jane Thakaew';        
        $attributes['email']    = 'jane_th@harrowschool.ac.th';    
        $attributes['username'] = 'jane_th';
        $attributes['telephone']= '025037222-1184';
        $attributes['password'] = Str::random(32);
        User::create($attributes);     
        
        $attributes['name']     = 'Ome Thiensri';        
        $attributes['email']    = 'ome_t@harrowschool.ac.th';    
        $attributes['username'] = 'ome_t';
        $attributes['telephone']= '025037222-1183';
        $attributes['password'] = Str::random(32);
        User::create($attributes);      
        
        $attributes['name']     = 'Fabian Pearce';        
        $attributes['email']    = 'fabian_pe@harrowschool.ac.th';    
        $attributes['username'] = 'fabian_pe';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);      
        
        $attributes['name']     = 'Ben Jenkins';        
        $attributes['email']    = 'benjamin_je@harrowschool.ac.th';    
        $attributes['username'] = 'benjamin_je';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);      
        
        $attributes['name']     = 'Juvelyn Escabusa';        
        $attributes['email']    = 'juvelyn_es@harrowschool.ac.th';    
        $attributes['username'] = 'juvelyn_es';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);      
        
        $attributes['name']     = 'Ruth Cowap';        
        $attributes['email']    = 'ruth_co@harrowschool.ac.th';    
        $attributes['username'] = 'ruth_co';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);      
        
        $attributes['name']     = 'Sue Beasley';        
        $attributes['email']    = 'sue_be@harrowschool.ac.th';    
        $attributes['username'] = 'sue_be';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);    
        
        $attributes['name']     = 'Nang Chichareaon';        
        $attributes['email']    = 'nang_c@harrowschool.ac.th';    
        $attributes['username'] = 'nang_c';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);    
        
        $attributes['name']     = 'Tamsin Dyke';        
        $attributes['email']    = 'tamsin_dy@harrowschool.ac.th';    
        $attributes['username'] = 'tamsin_dy';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);    
        
        $attributes['name']     = 'Paul Shufflebotham';        
        $attributes['email']    = 'paul_sh@harrowschool.ac.th';    
        $attributes['username'] = 'paul_sh';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes);    
        
        $attributes['name']     = 'Jen Shufflebotham';        
        $attributes['email']    = 'jennifer_sh@harrowschool.ac.th';    
        $attributes['username'] = 'jennifer_sh';
        $attributes['telephone']= '';
        $attributes['password'] = Str::random(32);
        User::create($attributes); 
    }
};
