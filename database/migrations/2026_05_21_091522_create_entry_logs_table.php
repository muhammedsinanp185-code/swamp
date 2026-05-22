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
        Schema::create('entry_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('visitor_pass_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('scanned_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('type', ['check_in', 'check_out']);
            $table->boolean('manual_entry')->default(false);
            $table->text('notes')->nullable();
            $table->dateTime('scanned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_logs');
    }
};
