<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gallery_image');
            $table->integer('gallery_id')->unsigned()->nullable();
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
            $table->foreign('gallery_id')->references('id')->on('galleries')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_products');
    }
}
