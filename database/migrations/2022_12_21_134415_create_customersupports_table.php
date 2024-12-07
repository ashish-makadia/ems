<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customersupports', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('Description');
            $table->string('file')->nullable();
            $table->string('website')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->string('mail');
            $table->string('mobile');
            $table->string('priority');
            $table->string('delivery_date');
            $table->enum('status',['Open','Close']);
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('customersupports');
    }
}
