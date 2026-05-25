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
    $today = Carbon::now();

    $totalVisitorsToday = EntryLog::whereDate('scanned_at', $today->toDateString())->count();

    $activePasses = VisitorPass::where(function ($q) use ($today) {
        $q->where('status', 'active')
          ->orWhere(function ($q2) use ($today) {
              $q2->where('valid_from', '<=', $today)
                 ->where('valid_until', '>=', $today);
          });
    })->count();

    $entriesLogged = EntryLog::count();

    $recentLogs = EntryLog::with(['pass.visitor'])
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
            'status' => $log->type === 'in' ? 'Checked In' : ($log->type === 'out' ? 'Checked Out' : ucfirst($log->type)),
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
