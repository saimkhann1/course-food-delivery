<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category; 
use App\Models\Product; 
use App\Models\Restaurant; 
    
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    $this->call([
        PermissionSeeder::class,
        RoleSeeder::class,
        CitySeeder::class,
        UserSeeder::class,
    ]);
    $this->seedDemoRestaurants();
}       
    public function seedDemoRestaurants()
    {
        $products =Product::factory(7);
        $categories=Category::factory(5)->has($products);
        $restaurant=Restaurant::factory()->has($categories);
        
        User::factory(50)->vendor()->has($restaurant)->create();
    }
}   
