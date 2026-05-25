<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParcelController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id ?? null;

        $query = Parcel::query();

        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }

        $parcels = $query->latest()
            ->get()
            ->map(function ($parcel) {
                return [
                    'id' => $parcel->id,
                    'courier_name' => $parcel->courier_name,
                    'tracking_number' => $parcel->tracking_number,
                    'recipient_name' => $parcel->recipient_name,
                    'status' => $parcel->status,
                    'arrived_at' => $parcel->arrived_at ? $parcel->arrived_at->format('Y-m-d H:i') : $parcel->created_at->format('Y-m-d H:i'),
                ];
            });

        return Inertia::render('Parcels/Index', [
            'parcels' => $parcels,
        ]);
    }

    public function create()
    {
        return Inertia::render('Parcels/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'courier_name' => 'required|string|max:255',
            'tracking_number' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'status' => 'required|in:received,collected',
            'arrived_at' => 'required|date',
            'photo_url' => 'nullable|url|max:2048',
        ]);

        $payload = array_merge($validated, [
            'organization_id' => auth()->user()->organization_id ?? null,
        ]);

        Parcel::create($payload);

        return redirect()->route('parcels.index')->with('success', 'Parcel logged successfully.');
    }
}
