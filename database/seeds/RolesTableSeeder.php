<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Manager of bookshop'
        ]);
        DB::table('roles')->insert([
            'name' => 'Customer',
            'slug' => 'customer',
            'description' => 'Customer of bookshop'
        ]);
    }
}
