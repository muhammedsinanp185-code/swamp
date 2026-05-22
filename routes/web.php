<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $orgId = auth()->user()->organization_id;
    
    $totalVisitorsToday = \App\Models\VisitorPass::where('organization_id', $orgId)->whereDate('created_at', today())->count();
    $activePasses = \App\Models\VisitorPass::where('organization_id', $orgId)->where('status', 'active')->count();
    $entriesLogged = \App\Models\EntryLog::where('organization_id', $orgId)->whereDate('created_at', today())->count();
    
    $recentVisitors = \App\Models\VisitorPass::with('visitor')
        ->where('organization_id', $orgId)
        ->latest()
        ->take(4)
        ->get()
        ->map(function ($pass) {
            return [
                'id' => $pass->id,
                'name' => $pass->visitor ? $pass->visitor->name : 'Unknown',
                'purpose' => $pass->purpose,
                'time' => $pass->created_at->format('h:i A'),
                'status' => $pass->status === 'active' ? 'Active' : ucfirst($pass->status)
            ];
        });

    return Inertia::render('Dashboard', [
        'stats' => [
            'totalVisitorsToday' => $totalVisitorsToday,
            'activePasses' => $activePasses,
            'entriesLogged' => $entriesLogged,
        ],
        'recentVisitors' => $recentVisitors
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
    Route::resource('settings', App\Http\Controllers\SettingsController::class);
    Route::get('scanner', [App\Http\Controllers\QRScannerController::class, 'index'])->name('scanner.index');
});

require __DIR__.'/auth.php';
