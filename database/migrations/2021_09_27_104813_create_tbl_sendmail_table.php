<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSendmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sendmail', function (Blueprint $table) {
            $table->id();
            $table->Integer('manage_id');
            $table->string('mail_attachment_file')->nullable();
            $table->longtext('mail_description')->nullable();
            $table->enum('user_type', array('0','1','2'))->nullable()->comment = "0 = Booking, 1 = Agent, 2 = Client ";
            $table->enum('mail_attachment_status',['0','1'])->nullable()->comment = "0 = No, 1 = Yes";
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
        Schema::dropIfExists('tbl_sendmail');
    }
}
