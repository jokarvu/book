<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('1234'),
            'email' => 'admin@book.com',
            'address' => '21 St.Paul Sreet, Weston',
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'username' => 'usernor',
            'password' => bcrypt('1234'),
            'email' => 'usernor@book.com',
            'address' => '73 Martin, Texas',
            'role_id' => 2,
        ]);
    }
}
