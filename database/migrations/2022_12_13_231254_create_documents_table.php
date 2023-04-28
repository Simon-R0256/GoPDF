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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('id');                                                                                           
            $table->foreignId('owner_id')->references('id')->on('users')->onDelete('cascade');                          
            $table->string('document_name');                                                                           
            $table->string('release_state')->default('Privat'); 
            $table->timestamps();
        });

        //BLOB-Type, hier wird der Inhalt des Dokuments gespeichert
        DB::statement("ALTER TABLE documents ADD document_data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
