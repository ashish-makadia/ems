<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToCustomerSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('customersupports', 'status')){
            Schema::table('customersupports', function(Blueprint $table)
            {
                $table->dropColumn('status');
            });
            Schema::table('customersupports', function (Blueprint $table) {
                $table->enum('status',['Todo','In Progress','BackLog','Done','Tested','Completed'])->nullable()->after("ticket_id");
            });
        } else {
            Schema::table('customersupports', function (Blueprint $table) {
                $table->enum('status',['Todo','In Progress','BackLog','Done','Tested','Completed'])->nullable()->after("ticket_id");
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
        Schema::table('customer_support', function (Blueprint $table) {
            //
        });
    }
}
