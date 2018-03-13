<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfluencerVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('influencer_id')->unsigned()->nullable();

            $table->timestamps();
            $table->foreign('influencer_id')->references('id')->on('influencers')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_videos');
    }
}
