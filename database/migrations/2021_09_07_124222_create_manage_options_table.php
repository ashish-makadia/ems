<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_options', function (Blueprint $table) {
            $table->id();
            $table->longtext('screen_options');
            $table->longtext('scren_option_array_en')->nullable();
            $table->longtext('scren_option_array_it')->nullable();
            $table->enum('is_view', array('0'))->nullable()->comment = "0 = Admin";
            $table->string('view_type')->nullable();
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
        Schema::dropIfExists('manage_options');
    }
}
