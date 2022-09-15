<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
          'first_name' => 'Super',
          'last_name' => 'Admin',
          'email' => 'admin@efghr.com',
          'password' => 'password',
          'is_admin' => true,
        ]);
        $user->save();
        $user->markEmailAsVerified();
    }
}
