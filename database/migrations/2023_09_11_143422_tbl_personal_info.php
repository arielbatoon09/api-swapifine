<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_personal_info', function (Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->string('legalname');
            $table->string('birthdate');
            $table->string('card_id_img');
            $table->integer('verification_status')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
