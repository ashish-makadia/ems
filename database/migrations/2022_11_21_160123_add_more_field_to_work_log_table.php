<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldToWorkLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_log', function (Blueprint $table) {
            // $table->text('time_spent')->nullable()->after("log_date");
            // $table->text('remaining_estimate_type')->nullable()->after("log_date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_log', function (Blueprint $table) {

        });
    }
}
