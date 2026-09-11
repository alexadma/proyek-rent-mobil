<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            if (! Schema::hasColumn('transaksi', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('id');
                $table->index('customer_id');
            }
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE mobils MODIFY foto VARCHAR(255) NULL');

            DB::statement('ALTER TABLE supirs MODIFY image VARCHAR(255) NULL');
            DB::statement('ALTER TABLE supirs MODIFY noktp BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE supirs DROP PRIMARY KEY');
            DB::statement('ALTER TABLE supirs MODIFY noktp VARCHAR(20) NOT NULL');
            DB::statement('ALTER TABLE supirs ADD PRIMARY KEY (noktp)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transaksi') && Schema::hasColumn('transaksi', 'customer_id')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->dropIndex(['customer_id']);
                $table->dropColumn('customer_id');
            });
        }
    }
};
