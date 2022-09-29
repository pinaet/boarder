<?php

use App\Models\PermissionContent;
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
        
        Schema::create('permission_contents', function (Blueprint $table) {
            $table->id();
            $table->string('permission_content_name');
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
        Schema::dropIfExists('permission_contents');
    }


    public function generate()
    {
        $contents = array(
            'Bradbys',
            'Junior Girls',
            'The Grove',
            'West Acre',
        );
        foreach ($contents as $content) {
            PermissionContent::create(['permission_content_name'=>$content]);
        }
    }
};
