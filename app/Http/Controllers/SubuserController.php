<?php

namespace App\Http\Controllers;

use App\Models\Subuser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubuserController extends Controller
{
    public function index()
    {
        $subusers = Subuser::where('organization_id', auth()->user()->organization_id)
            ->with(['parentUser', 'organization'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Subusers/Index', [
            'subusers' => $subusers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Subusers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:subusers',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:subuser,manager,viewer',
            'is_active' => 'boolean',
        ]);

        $subuser = Subuser::create([
            'organization_id' => auth()->user()->organization_id,
            'parent_user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('subusers.index')->with('success', 'Subuser created successfully');
    }

    public function edit(Subuser $subuser)
    {
        $this->authorize('update', $subuser);

        return Inertia::render('Subusers/Edit', [
            'subuser' => $subuser,
        ]);
    }

    public function update(Request $request, Subuser $subuser)
    {
        $this->authorize('update', $subuser);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:subusers,email,' . $subuser->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:subuser,manager,viewer',
            'is_active' => 'boolean',
        ]);

        $subuser->update($validated);

        return redirect()->route('subusers.index')->with('success', 'Subuser updated successfully');
    }

    public function destroy(Subuser $subuser)
    {
        $this->authorize('delete', $subuser);

        $subuser->delete();

        return redirect()->route('subusers.index')->with('success', 'Subuser deleted successfully');
    }
}
