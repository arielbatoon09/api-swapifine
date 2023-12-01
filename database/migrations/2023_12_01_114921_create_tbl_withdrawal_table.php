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
        Schema::create('tbl_withdrawal', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('transfer_to');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
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
        Schema::dropIfExists('tbl_withdrawal');
    }
};
