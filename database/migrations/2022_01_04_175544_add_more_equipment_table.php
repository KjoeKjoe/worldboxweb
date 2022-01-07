<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slaves', function (Blueprint $table) {
            $table->string('boots')->nullable()->after('armor');
            $table->string('amulet')->nullable()->after('armor');
            $table->string('bodyarmor')->nullable()->after('armor');
            $table->string('helmet')->nullable()->after('armor');
            $table->string('weapon')->nullable()->after('armor');
            $table->string('ring')->nullable()->after('armor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
