<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->default('System');  // nama user yang melakukan aksi
            $table->string('action');                         // created, updated, deleted
            $table->string('model_type');                     // Customer, Package, Transaction
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('description');                      // deskripsi aksi
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
