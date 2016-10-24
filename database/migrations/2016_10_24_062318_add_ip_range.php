<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dnsips', function ($table) {
            $table->dropColumn('iprange');
        });
        Schema::table('dnsips', function ($table) {
            $table->integer('range')->default(32);
            $table->bigInteger('ipstart');
            $table->bigInteger('ipend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dnsips', function ($table) {
            $table->string('iprange');
        });
        Schema::table('dnsips', function ($table) {
            $table->dropColumn('range');
            $table->dropColumn('ipstart');
            $table->dropColumn('ipend');
        });
    }
}
