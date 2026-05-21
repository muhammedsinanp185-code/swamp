<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

$schemas = [
    'create_visitors_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('id_proof_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
PHP,
    'create_visitor_passes_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('visitor_passes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('visitor_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('host_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->uuid('qr_uuid')->unique();
            $table->string('purpose')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->string('type')->default('single'); // single, reusable
            $table->string('status')->default('pending'); // pending, active, expired, cancelled
            $table->timestamps();
            $table->softDeletes();
        });
    }
PHP,
    'create_entry_logs_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('entry_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('visitor_pass_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignUuid('scanned_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('type'); // entry, exit
            $table->boolean('manual_entry')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('scanned_at');
            $table->timestamps();
        });
    }
PHP,
    'create_vehicles_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('cascade'); // Owner
            $table->string('vehicle_number');
            $table->string('type')->nullable(); // car, bike, truck
            $table->boolean('is_frequent')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
PHP,
    'create_parcels_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('recipient_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('courier_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('status')->default('received'); // received, collected
            $table->timestamps();
            $table->softDeletes();
        });
    }
PHP,
    'create_workers_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // maid, contractor, staff
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->string('photo_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
PHP,
    'create_subscriptions_table' => <<<'PHP'
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->onDelete('cascade');
            $table->string('plan_name');
            $table->string('stripe_id')->nullable();
            $table->string('status');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }
PHP,
];

foreach ($files as $file) {
    if (str_ends_with($file, '.php')) {
        foreach ($schemas as $key => $schema) {
            if (str_contains($file, $key)) {
                $path = $dir . $file;
                $content = file_get_contents($path);
                $content = preg_replace('/public function up\(\): void\s*\{\s*Schema::create\([^;]+;\s*\}\s*\}/s', $schema, $content);
                file_put_contents($path, $content);
                echo "Updated $file\n";
            }
        }
    }
}

echo "Done.\n";
