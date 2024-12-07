<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssinedByToCustomersupports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customersupports', function (Blueprint $table) {
            //
            $table->bigInteger("assined_by")->nullable()->after("ticket_id");
            $table->bigInteger("serial_no")->nullable()->after("ticket_id");
            $table->string("ticket_id")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customersupports', function (Blueprint $table) {
            //
        });
    }
}
