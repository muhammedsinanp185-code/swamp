<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index', [
            'preferences' => auth()->user()->preferences ?? [
                'language' => 'en',
                'time_format' => '24h',
                'notifications_sms' => false,
                'notifications_email' => true,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|string|max:10',
            'time_format' => 'required|in:12h,24h',
            'notifications_sms' => 'boolean',
            'notifications_email' => 'boolean',
        ]);

        auth()->user()->update([
            'preferences' => $validated,
        ]);

        return back()->with('success', 'General preferences saved.');
    }
}
