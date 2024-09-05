<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createCustomerUsers();
    }

    /**
     * Create customer users.
     *
     * @return void
     */
    protected function createCustomerUsers()
    {
        \App\Models\User::factory()->count(10)->create([
            'role' => 'admin', 
        ]);
    }
}
