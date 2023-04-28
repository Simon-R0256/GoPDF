<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api', function (Blueprint $table) {
            $table->foreignId('id')->references('id')->on('documents')->onDelete('cascade');                               
            //Dokumentenname entspricht auch dem Namen der Schnittstelle
            $table->string('document_name');
            //Call zeichnet die Aufrufe auf
            $table->integer('call')->default(0);
            //Hier werden die erwarteten Platzhalter gespeichert
            $table->binary('placeholder');
            $table->date('last_Call')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE api ADD document_data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api');
    }
};
