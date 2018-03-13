<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoryName');
            $table->string('image')->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->integer('sort_id');
            $table->string('keyword')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('confirm')->default(1);
            $table->tinyInteger('addedBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
