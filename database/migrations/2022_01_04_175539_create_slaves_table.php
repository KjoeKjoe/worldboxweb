<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slaves', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->integer('currency')->default(0);

            $table->boolean('spawned')->default(false);
            $table->boolean('died')->default(false);
            $table->string('gender')->default('male');
            $table->string('traits')->default('{"trait_data":[]}');

            //--Reset every spawn--//
            $table->integer('age')->default(1);
            $table->integer('kills')->default(0);
            $table->integer('children')->default(0);
            $table->integer('base_health')->default(100);
            $table->integer('health')->default(100);
            $table->integer('base_diplomacy')->default(0);
            $table->integer('diplomacy')->default(0);
            $table->integer('base_warfare')->default(0);
            $table->integer('warfare')->default(0);
            $table->integer('base_stewardship')->default(0);
            $table->integer('stewardship')->default(0);
            $table->integer('base_intelligence')->default(0);
            $table->integer('intelligence')->default(0);

            //new
            $table->integer('base_attack_speed')->default(0);
            $table->integer('attack_speed')->default(0);
            $table->integer('base_accuracy')->default(0);
            $table->integer('accuracy')->default(0);
            $table->integer('base_speed')->default(0);
            $table->integer('speed')->default(0);
            $table->integer('base_crit')->default(0);
            $table->integer('crit')->default(0);
            $table->integer('base_armor')->default(0);
            $table->integer('armor')->default(0);

            //map options
            $table->boolean('follow')->default(0);
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
        Schema::dropIfExists('slaves');
    }
}
