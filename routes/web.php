<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
    ]);
})->name('home');

use App\Models\EntryLog;
use App\Models\VisitorPass;
use Carbon\Carbon;

Route::get('/dashboard', function () {
    $now = Carbon::now();
    $organizationId = auth()->user()->organization_id;

    $totalVisitorsToday = \App\Models\Visitor::where('organization_id', $organizationId)
        ->whereDate('created_at', $now->toDateString())
        ->count();

    $activePasses = VisitorPass::where('organization_id', $organizationId)
        ->where('valid_from', '<=', $now)
        ->where('valid_until', '>=', $now)
        ->count();

    $entriesLogged = EntryLog::where('organization_id', $organizationId)->count();

    $recentLogs = EntryLog::where('organization_id', $organizationId)
        ->with(['pass.visitor'])
        ->orderBy('scanned_at', 'desc')
        ->take(5)
        ->get();

    $recentVisitors = $recentLogs->map(function ($log) {
        $visitor = $log->pass?->visitor;
        return [
            'id' => $log->id,
            'name' => $visitor?->name ?? 'Unknown',
            'purpose' => $log->pass?->purpose ?? '',
            'time' => optional($log->scanned_at)?->format('h:i A') ?? '',
            'status' => $log->type === 'check_in' ? 'Checked In' : ($log->type === 'check_out' ? 'Checked Out' : ucfirst($log->type)),
        ];
    })->toArray();

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalVisitorsToday' => $totalVisitorsToday,
            'activePasses' => $activePasses,
            'entriesLogged' => $entriesLogged,
        ],
        'recentVisitors' => $recentVisitors,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('visitors', App\Http\Controllers\VisitorController::class);
    Route::resource('organizations', App\Http\Controllers\OrganizationController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('parcels', App\Http\Controllers\ParcelController::class);
    Route::resource('subusers', App\Http\Controllers\SubuserController::class);
    Route::resource('settings', App\Http\Controllers\SettingsController::class)->only(['index']);
    Route::patch('settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('scanner', [App\Http\Controllers\QRScannerController::class, 'index'])->name('scanner.index');
});

require __DIR__.'/auth.php';
