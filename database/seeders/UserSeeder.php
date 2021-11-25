<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'first_name' => 'Moderator',
            'last_name' => 'Moderator',
            'email' => 'moderator@example.com',
            'role_id' => 2,
        ]);

        User::factory()->create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'viewer@example.com',
            'role_id' => 3,
        ]);
    }
}
