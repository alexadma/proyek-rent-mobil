<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql'
            && Schema::hasTable('transaksi')
            && Schema::hasColumn('transaksi', 'bukti')) {
            DB::statement('ALTER TABLE transaksi MODIFY bukti VARCHAR(255) NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql'
            && Schema::hasTable('transaksi')
            && Schema::hasColumn('transaksi', 'bukti')) {
            DB::statement('ALTER TABLE transaksi MODIFY bukti VARCHAR(255) NOT NULL');
        }
    }
};
