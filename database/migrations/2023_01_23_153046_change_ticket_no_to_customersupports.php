<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTicketNoToCustomersupports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customersupports', function (Blueprint $table) {
            $table->bigInteger("ticket_id")->change();
            $table->integer("status")->change();
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
