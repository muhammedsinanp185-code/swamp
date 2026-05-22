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
        Schema::create('visitor_passes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('visitor_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('host_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->uuid('qr_uuid')->unique()->nullable();
            $table->string('purpose');
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->enum('type', ['single', 'reusable'])->default('single');
            $table->enum('status', ['pending', 'active', 'expired', 'canceled'])->default('active');
            $table->string('qr_code_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_passes');
    }
};
