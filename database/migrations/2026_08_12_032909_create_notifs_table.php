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
        Schema::create('notifs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 10)->nullable()->index();
            $table->string('message', 255)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('number', 50)->nullable();
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->decimal('remaining_amount', 15, 2)->default(0.00);
            $table->string('va', 30)->nullable()->index();
            $table->dateTime('date')->nullable();
            $table->string('bank_code', 10)->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('ref', 80)->nullable();
            $table->string('channel', 30)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamp('time_notif')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};
