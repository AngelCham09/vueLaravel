<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\Staff;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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

        Staff::factory()
        ->count(5)
            ->has(
                // Each staff member has 3 purchases
                Purchase::factory()->count(3)
                    ->has(
                        // Each purchase has 5 items
                        Item::factory()->count(5)
                    )
            )
            ->create();
    }
}
