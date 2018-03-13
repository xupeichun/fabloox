<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYoutubeVidoesAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_videos', function (Blueprint $table) {
            $table->string('thumbnail')->nullable();
            $table->string('video_name')->nullable();
            $table->string('video_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_videos', function (Blueprint $table) {
            //
        });
    }
}
