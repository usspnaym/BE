<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
           'account' => 'admin',
           'email' => 'admin@admin.com',
           'password' => bcrypt('adminadmin'),
           'name' => 'Super Admin'
        ]);
        Category::create([
            'name' => '陸域生態系統破壞'
        ]);
        Category::create([
            'name' => '森林管理缺失'
        ]);
        Category::create([
            'name' => '沙漠化'
        ]);
        Category::create([
            'name' => '土地劣化'
        ]);
        Category::create([
            'name' => '生物多樣性喪失'
        ]);
        Post::create([
            'user_id' => 1,
            'name' => '石虎保育員',
            'content' => '參與石虎保育，對於台灣生態系做出實質貢獻',
            'lat' => 23.8815603,
            'lng' => 120.7640027
        ]);
    }
}
