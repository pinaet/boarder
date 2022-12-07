<?php

use App\Http\Controllers\SyncController;
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->string('contact_id')->unique();
            $table->string('pupil_id');
            $table->string('relationship')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
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
        Schema::dropIfExists('contacts');
    }


    public function generate()
    {
        (new SyncController)->syncContacts();
    }
};
