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
        if (Schema::hasColumn('parcels', 'organization_id')) {
            DB::statement('ALTER TABLE `parcels` MODIFY `organization_id` CHAR(36) NULL');
        }

        if (Schema::hasColumn('parcels', 'recipient_user_id')) {
            DB::statement('ALTER TABLE `parcels` MODIFY `recipient_user_id` CHAR(36) NULL');
        }

        Schema::table('parcels', function (Blueprint $table) {
            if (!Schema::hasColumn('parcels', 'organization_id')) {
                $table->char('organization_id', 36)->nullable();
            }

            if (!Schema::hasColumn('parcels', 'recipient_user_id')) {
                $table->char('recipient_user_id', 36)->nullable();
            }

            if (!Schema::hasColumn('parcels', 'courier_name')) {
                $table->string('courier_name')->nullable();
            }

            if (!Schema::hasColumn('parcels', 'tracking_number')) {
                $table->string('tracking_number')->nullable();
            }

            if (!Schema::hasColumn('parcels', 'recipient_name')) {
                $table->string('recipient_name')->nullable();
            }

            if (!Schema::hasColumn('parcels', 'status')) {
                $table->string('status')->default('received');
            }

            if (!Schema::hasColumn('parcels', 'arrived_at')) {
                $table->timestamp('arrived_at')->nullable();
            }

            if (!Schema::hasColumn('parcels', 'photo_url')) {
                $table->string('photo_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            if (Schema::hasColumn('parcels', 'courier_name')) {
                $table->dropColumn('courier_name');
            }
            if (Schema::hasColumn('parcels', 'tracking_number')) {
                $table->dropColumn('tracking_number');
            }
            if (Schema::hasColumn('parcels', 'recipient_name')) {
                $table->dropColumn('recipient_name');
            }
            if (Schema::hasColumn('parcels', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('parcels', 'arrived_at')) {
                $table->dropColumn('arrived_at');
            }
            if (Schema::hasColumn('parcels', 'photo_url')) {
                $table->dropColumn('photo_url');
            }
        });
    }
};
