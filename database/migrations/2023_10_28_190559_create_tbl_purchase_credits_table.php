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
        Schema::create('tbl_purchase_credits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('ref_key');
            $table->string('checkout_session_id');
            $table->string('purchase_name');
            $table->string('description');
            $table->string('payment_method');
            $table->string('checkout_url');
            $table->decimal('amount');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_purchase_credits');
    }
};
