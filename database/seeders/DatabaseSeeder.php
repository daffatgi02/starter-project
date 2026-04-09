<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $superAdmin = User::create([
            'name' => 'Daffa',
            'email' => 'daffatgi02@gmail.com',
            'password' => bcrypt('daffa123'),
            'email_verified_at' => now(),
            'status' => 'active',
        ]);

        $superAdmin->assignRole('super-admin');
    }
}
