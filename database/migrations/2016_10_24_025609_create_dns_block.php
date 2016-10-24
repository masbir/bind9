<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnsBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnsviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('dnsdomains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain'); 
            $table->integer('dnsview_id'); 
            $table->timestamps();
        });  

        Schema::create('dnsips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iprange'); 
            $table->integer('dnsview_id'); 
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
        Schema::drop('dnsviews');
        Schema::drop('dnsdomains');
        Schema::drop('dnsips');
    }
}
