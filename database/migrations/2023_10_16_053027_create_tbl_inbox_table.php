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
        Schema::create('tbl_inbox', function (Blueprint $table) {
            $table->id();
            $table->string('inbox_key');
            $table->integer('from_id')->unsigned();
            $table->integer('to_id')->unsigned();
            $table->string('post_item_key');
            $table->integer('read_by_sender')->unsigned();
            $table->integer('read_by_receiver')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_inbox');
    }
};
