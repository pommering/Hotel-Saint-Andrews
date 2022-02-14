<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCleanRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('clean_rooms', function (Blueprint $table) {
            $table->dropForeign('clean_rooms_activitie_id_foreign');
            $table->dropColumn('activitie_id');
        });

        Schema::create('clean_room_tarefas', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('clean_room_id');
            $table->unsignedBigInteger('tarefas_id');
            $table->foreign('clean_room_id')->references('id')->on('clean_rooms')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tarefas_id')->references('id')->on('activities')->onUpdate('cascade')->onDelete('cascade');
        });

        //clean_room_tarefas
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('clean_room_tarefas');

        Schema::table('clean_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('activitie_id');
            $table->foreign('activitie_id')->references('id')->on('activities')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
