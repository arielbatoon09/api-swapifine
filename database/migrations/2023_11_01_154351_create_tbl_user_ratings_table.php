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
        Schema::create('tbl_user_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('rated_by_id')->unsigned();
            $table->integer('rated_to_id')->unsigned();
            $table->integer('scale_ratings')->unsigned();
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_ratings');
    }
};
