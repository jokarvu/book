<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Tiểu thuyết',
            'slug' => 'tieu-thuyet',
            'description' => 'This is a test description'
        ]);
    }
}
