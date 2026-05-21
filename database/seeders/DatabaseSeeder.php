<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $org = \App\Models\Organization::create([
            'name' => 'Demo Organization',
            'type' => 'Office Building',
            'is_active' => true,
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@swamp.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'organization_id' => $org->id,
        ]);
    }
}
