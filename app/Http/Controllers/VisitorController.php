<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class VisitorController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id;
        $now = \Illuminate\Support\Carbon::now();

        $visitors = \App\Models\Visitor::where('organization_id', $organizationId)
            ->with(['passes.host'])
            ->latest()
            ->get()
            ->map(function ($visitor) use ($now) {
                $latestPass = $visitor->passes->sortByDesc('valid_from')->first();
                $status = $latestPass ? $latestPass->current_status : 'N/A';

                return [
                    'id' => $visitor->id,
                    'name' => $visitor->name,
                    'phone' => $visitor->phone,
                    'email' => $visitor->email,
                    'host_name' => $latestPass ? ($latestPass->host ? $latestPass->host->name : 'N/A') : 'N/A',
                    'valid_until' => $latestPass ? $latestPass->valid_until->format('d-m-Y H:i') : 'N/A',
                    'status' => $status,
                ];
            });

        return Inertia::render('Visitors/Index', [
            'visitors' => $visitors
        ]);
    }

    public function create()
    {
        return Inertia::render('Visitors/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'purpose' => 'required|string|max:255',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'type' => 'required|in:single,reusable',
        ]);

        $organizationId = auth()->user()->organization_id;

        // Create or Update Visitor
        $visitor = \App\Models\Visitor::firstOrCreate(
            ['phone' => $validated['phone'], 'organization_id' => $organizationId],
            ['name' => $validated['name'], 'email' => $validated['email']]
        );

        // Parse dates properly before storing
        $validFrom = \Illuminate\Support\Carbon::parse($validated['valid_from'])->utc();
        $validUntil = \Illuminate\Support\Carbon::parse($validated['valid_until'])->utc();

        // Determine pass status based on the validity window
        $status = $validFrom->isFuture() ? 'pending' : ($validUntil->isPast() ? 'expired' : 'active');

        // Create Pass
        \App\Models\VisitorPass::create([
            'organization_id' => $organizationId,
            'visitor_id' => $visitor->id,
            'host_user_id' => auth()->id(),
            'purpose' => $validated['purpose'],
            'valid_from' => $validFrom,
            'valid_until' => $validUntil,
            'type' => $validated['type'],
            'status' => $status,
            'qr_uuid' => (string) \Illuminate\Support\Str::uuid()
        ]);

        return redirect()->route('visitors.index')->with('success', 'Visitor pass created successfully.');
    }

    public function show(string $id)
    {
        // TODO
    }

    public function edit(string $id)
    {
        // TODO
    }

    public function update(Request $request, string $id)
    {
        // TODO
    }

    public function destroy(string $id)
    {
        // TODO
    }
}
