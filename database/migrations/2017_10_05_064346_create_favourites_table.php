<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {


            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');

            $table->unsignedBigInteger('merchantId')->nullable();
            $table->unsignedBigInteger('linkId')->nullable();
            $table->dateTime('createdOn')->nullable();
            $table->string('sku')->nullable();
            $table->string('productName')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('secondaryCategoryName')->nullable();
            $table->string('currency')->nullable();
            $table->string('priceCurrency')->nullable();
            $table->string('salePriceCurrency')->nullable();
            $table->longText('shortDescription')->nullable();
            $table->longText('longDescription')->nullable();
            $table->text('linkUrl')->nullable();
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}


//
//
//    "id": 1,
//        "merchantId": 41104,
//        "merchantName": "Beauty Bay",
//        "linkId": 11223848828,
//        "createdOn": "2017-09-15/09:46:43",
//        "sku": "PAJC1670F",
//        "productName": "Lipstick Case N",
//        "categoryName": "Makeup Bags & Storage",
//        "secondaryCategoryName": "",
//        "currency": "$",
//        "priceCurrency": "$7.0",
//        "salePriceCurrency": "$7.0",
//        "shortDescription": "Durable, easy-to-clean black nylon large brush roll with a silky reflective interior and black faux-patent handles and straps.",
//        "longDescription": "Durable, easy-to-clean black nylon large brush roll with a silky reflective interior and black faux-patent handles and straps. Features 18 brush pockets, one zipper pouch and two small open pouches on the other side.",
//        "linkUrl": "http://click.linksynergy.com/link?id=75PwxuO*sL8&offerid=509875.11223848828&type=15&murl=http%3A%2F%2Fwww.beautybay.com%2Fmakeup%2Fpauljoe%2Flipstickcasen%3Fctyid%3Dgb",
//        "image": "http://images.contentful.com/eoaaqxyywn6o/1gn3LM82lgsiouOKO46Ykw/6fef2ba8736a0255d96b8112a7dfd677/PAJC1670F_1_L.jpg"
