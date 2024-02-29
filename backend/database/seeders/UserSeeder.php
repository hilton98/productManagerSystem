<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
          'name' => 'Bringel User',
          'email' => 'user@bringel.com',
          'password' => bcrypt('Userbringel123#')
        ]);
    }
}
