<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL: cast varchar → numeric before changing column type
        DB::statement('ALTER TABLE transaksi ALTER COLUMN total_biaya TYPE numeric(15,2) USING total_biaya::numeric(15,2)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE transaksi ALTER COLUMN total_biaya TYPE varchar(255) USING total_biaya::varchar');
    }
};
