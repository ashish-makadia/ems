<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketIdToCustomersupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customersupports', function (Blueprint $table) {
            $table->string('ticket_id')->nullable()->after("status");
            $table->string('url')->nullable()->after("ticket_id");
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
