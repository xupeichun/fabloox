<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestOnfablooxIdsToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('best_on_fablooxes', function (Blueprint $table) {
            $table->longText('linkId')->nullable()->change();
            $table->longText('merchantId')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('best_on_fablooxes', function (Blueprint $table) {
            //
        });
    }
}
