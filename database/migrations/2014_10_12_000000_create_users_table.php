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
        $attributes['name']     = 'Pinaet Poonsarakhun';        
        $attributes['email']    = 'naet_ph@harrowschool.ac.th';    
        $attributes['username'] = 'naet_ph';
        $attributes['telephone']= '025037222-1256';
        $attributes['password'] = Str::random(32);
        User::create($attributes);     
    }
};
