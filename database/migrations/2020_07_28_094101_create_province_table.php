<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('province')) {
        Schema::create('province', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('province_name');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('region');
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
        Schema::table('province', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });
        Schema::dropIfExists('province');
    }
}
