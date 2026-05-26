<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VisitorPass;

class UpdateVisitorStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of visitor passes based on their validity period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $expiredCount = VisitorPass::where('status', '!=', 'expired')
            ->where('status', '!=', 'canceled')
            ->where('valid_until', '<', $now)
            ->update(['status' => 'expired']);

        $activeCount = VisitorPass::where('status', 'pending')
            ->where('valid_from', '<=', $now)
            ->where('valid_until', '>=', $now)
            ->update(['status' => 'active']);

        $this->info("Updated {$expiredCount} passes to expired and {$activeCount} passes to active.");
    }
}
