<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Visitor;

$visitors = Visitor::with('passes.host')->get();
if ($visitors->isEmpty()) {
    echo "no visitors\n";
    exit(0);
}

echo "now=" . now()->toDateTimeString() . "\n";
foreach ($visitors as $visitor) {
    echo "visitor={$visitor->id} {$visitor->name}\n";
    foreach ($visitor->passes as $pass) {
        echo "  pass={$pass->id} status={$pass->status} valid_from={$pass->valid_from} valid_until={$pass->valid_until} current_status={$pass->current_status}\n";
    }
}
