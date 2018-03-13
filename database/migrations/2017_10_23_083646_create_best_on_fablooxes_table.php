<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestOnFablooxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_on_fablooxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('linkId')->nullable();
            $table->string('productName')->nullable();
            $table->unsignedBigInteger('merchantId')->nullable();
            $table->string('sku')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('secondaryCategoryName')->nullable();
            $table->string('currency')->nullable();
            $table->string('priceCurrency')->nullable();
            $table->string('salePriceCurrency')->nullable();
            $table->longText('shortDescription')->nullable();
            $table->longText('longDescription')->nullable();
            $table->text('linkUrl')->nullable();
            $table->text('image')->nullable();
            $table->text('merchant_name')->nullable();

            $table->dateTime('createdOn')->nullable();
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
        Schema::dropIfExists('best_on_fablooxes');
    }
}
