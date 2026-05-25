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
        DB::statement('ALTER TABLE `parcels` MODIFY `id` BIGINT UNSIGNED NOT NULL');
        
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropPrimary();
        });

        DB::statement('ALTER TABLE `parcels` MODIFY `id` CHAR(36) NOT NULL');

        Schema::table('parcels', function (Blueprint $table) {
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `parcels` MODIFY `id` BIGINT UNSIGNED NOT NULL');

        Schema::table('parcels', function (Blueprint $table) {
            $table->dropPrimary();
        });

        DB::statement('ALTER TABLE `parcels` MODIFY `id` BIGINT UNSIGNED AUTO_INCREMENT NOT NULL');

        Schema::table('parcels', function (Blueprint $table) {
            $table->primary('id');
        });
    }
};
