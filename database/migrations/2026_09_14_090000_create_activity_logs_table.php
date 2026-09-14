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
            $table->string('type');           // mobil, supir, transaksi
            $table->string('action');         // create, update, delete
            $table->string('description');    // deskripsi singkat
            $table->string('user', 100)->nullable(); // nama admin
            $table->json('details')->nullable();     // data tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
