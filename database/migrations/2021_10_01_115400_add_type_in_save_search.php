<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInSaveSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('save_search', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_search', function (Blueprint $table) {
            //
        });
    }
}
