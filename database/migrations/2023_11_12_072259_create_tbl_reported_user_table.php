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
        Schema::create('tbl_reported_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('reported_by');
            $table->string('message');
            $table->string('proof_img_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reported_user');
    }
};
