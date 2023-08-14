<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // and this for test
        User::create([
            'name' => 'username',
            'email' => 'user@email.com',
            'password' => bcrypt('userpass'),
        ]);
        // create 10 users
        User::factory(10)->create();

    }
}
