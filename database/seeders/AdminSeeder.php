<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $admin = [
            [
                'name' => 'SuperAdmin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'hash' => 4321,
                'admin_level' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        User::firstOrCreate(
            ['email' => $admin[0]['email']],
            [
                'name' => $admin[0]['name'],
                'password' => $admin[0]['password'],
                'hash' => $admin[0]['hash'],
                'admin_level' => $admin[0]['admin_level'],
            ]
        );
    }
}
