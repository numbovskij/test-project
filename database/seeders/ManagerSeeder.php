<?php

namespace Database\Seeders;

use App\Models\User;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create(
            [
                'email'      => 'manager@gmail.com',
                'name'       => 'manager',
                'password'   => Hash::make('secret'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role'       => User::ROLE_MANAGER
            ]
        );
    }
}
