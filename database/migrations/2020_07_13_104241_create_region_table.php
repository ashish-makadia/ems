<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('region')) {
        Schema::create('region', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('region_name');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('country');
            $table->enum('status', ['0', '1'])->default('1')->comment('0-Inactive, 1-Active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('seo_title')->nullable();
            $table->longtext('seo_description')->nullable();
            $table->string('seo_rewrite_url')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('region', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });
        Schema::dropIfExists('region');
    }
}
