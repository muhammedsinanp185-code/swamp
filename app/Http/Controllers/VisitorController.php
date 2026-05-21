<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class VisitorController extends Controller
{
    public function index()
    {
        // Dummy data for now
        $visitors = [
            [
                'id' => 1,
                'name' => 'Alice Cooper',
                'phone' => '+1 555-0100',
                'photo_url' => null,
                'host_name' => 'John Doe',
                'valid_until' => '2026-05-21 17:00:00',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Bob Marley',
                'phone' => '+1 555-0200',
                'photo_url' => null,
                'host_name' => 'Sarah Smith',
                'valid_until' => '2026-05-22 10:00:00',
                'status' => 'pending'
            ]
        ];

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
        // TODO
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
