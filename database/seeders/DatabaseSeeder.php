<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CampaignCategory;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach ([
            'Medical Support',
            'Education',
            'Food Distribution',
            'Child Welfare',
            'Community Development',
        ] as $name) {
            CampaignCategory::firstOrCreate(['name' => $name]);
        }
    }
}
