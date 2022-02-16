<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clean_rooms', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });

        Schema::table('clean_room_tarefas', function (Blueprint $table) {
            $table->time('time_execution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clean_room_tarefas', function (Blueprint $table) {
            $table->dropColumn('time_execution');
        });

        Schema::table('clean_rooms', function (Blueprint $table) {
            $table->dateTime('end_date');
        });
    }
}
