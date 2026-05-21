<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ParcelController extends Controller
{
    public function index()
    {
        $parcels = [
            [
                'id' => 1,
                'courier_name' => 'Amazon',
                'tracking_number' => 'AMZ-123456789',
                'recipient_name' => 'John Doe',
                'status' => 'received',
                'arrived_at' => '2026-05-21 09:30:00'
            ],
            [
                'id' => 2,
                'courier_name' => 'FedEx',
                'tracking_number' => 'FDX-987654321',
                'recipient_name' => 'Sarah Smith',
                'status' => 'collected',
                'arrived_at' => '2026-05-20 14:15:00'
            ]
        ];

        return Inertia::render('Parcels/Index', [
            'parcels' => $parcels
        ]);
    }
}
