<?php

use App\Models\AllowedUser;
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
        
        Schema::create('allowed_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
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
        Schema::dropIfExists('allowed_users');
    }


    public function generate()
    {
        $emails = array(
            'naet_ph@harrowschool.ac.th',
            'korn_ph@harrowschool.ac.th',
            'jane_th@harrowschool.ac.th'
        );
        foreach( $emails as $email) {
            AllowedUser::create(['email'=>$email]);
        }
    }
};
