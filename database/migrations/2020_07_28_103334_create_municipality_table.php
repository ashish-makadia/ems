<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if(!Schema::hasTable('municipality')) {
        Schema::create('municipality', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('municipality_name');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('id')->on('province');
             $table->unsignedBigInteger('region_id')->nullable();
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
        Schema::table('municipality', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
        });
        Schema::dropIfExists('municipality');
    }
}
