<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSaveSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('save_search', function (Blueprint $table) {
            $table->string('agent_id')->nullable();
            $table->string('region_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('municipality_id')->nullable();
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
