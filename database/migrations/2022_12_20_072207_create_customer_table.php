<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->bigInteger('country')->nullable();
            $table->bigInteger('region')->nullable();
            $table->bigInteger('province')->nullable();
            $table->bigInteger('municipality')->nullable();
            $table->string('zipcode')->nullable();
            $table->text('address')->nullable();
            $table->string('company_email');
            $table->string('company_phone')->nullable();
            $table->string('company_mobile')->nullable();
            $table->string('website')->nullable();
            $table->string('vat_id')->nullable();
            $table->string('fiscal_code')->nullable();
            $table->bigInteger('category');
            $table->bigInteger('subCategory');
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
        Schema::dropIfExists('customer');
    }
}
