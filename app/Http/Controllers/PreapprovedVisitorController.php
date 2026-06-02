<?php

namespace App\Http\Controllers;

use App\Models\VisitorPass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PreapprovedVisitorController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id;

        $preapprovedVisitors = VisitorPass::where('organization_id', $organizationId)
            ->where('status', 'pending')
            ->with(['visitor', 'host'])
            ->latest()
            ->get()
            ->map(function ($pass) {
                return [
                    'id' => $pass->id,
                    'visitor_name' => $pass->visitor?->name ?? 'Unknown',
                    'visitor_email' => $pass->visitor?->email,
                    'visitor_phone' => $pass->visitor?->phone,
                    'purpose' => $pass->purpose,
                    'host_name' => $pass->host?->name ?? 'N/A',
                    'valid_from' => $pass->valid_from->format('d-m-Y H:i'),
                    'valid_until' => $pass->valid_until->format('d-m-Y H:i'),
                    'pass_type' => $pass->type,
                    'qr_uuid' => $pass->qr_uuid,
                ];
            });

        return Inertia::render('PreapprovedVisitors/Index', [
            'preapprovedVisitors' => $preapprovedVisitors
        ]);
    }
}
