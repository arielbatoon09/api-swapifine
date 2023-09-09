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
        Schema::create('tbl_post_item', function (Blueprint $table) {
            $table->id();
            $table->string('item_key')->unique();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('location_id');
            $table->string('item_name');
            $table->string('item_description');
            $table->decimal('item_price');
            $table->integer('item_quantity');
            $table->string('condition');
            $table->string('item_for_type');
            $table->string('delivery_type');
            $table->integer('count_favorites')->default(0);
            $table->integer('is_available')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_post_item');
    }
};
