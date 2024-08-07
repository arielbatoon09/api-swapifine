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
        Schema::create('tbl_verification', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('legal_name');
            $table->string('address');
            $table->string('city');
            $table->string('zip_code');
            $table->string('dob');
            $table->string('img_file_path');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_verification');
    }
};
