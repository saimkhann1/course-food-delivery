<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $this->createAdminUser();
         $this->createVendorUser();
    }

    public function createAdminUser()
    {
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());
    }

    public function createVendorUser()
    {
        $vendor = User::create([
            'name'     => 'Restaurant Vendor',
            'email'    => 'vendor@admin.com',
            'password' => bcrypt('password'),
        ]);

        $vendor->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first());

        // 👇 YAHAN CHANGE KIYA HAI 👇
        // Pehle check karega 'Vilnius' hai? Agar nahi, to bana dega.
        $city = City::firstOrCreate(
            ['name' => 'Vilnius'] 
        );

        $vendor->restaurant()->create([
            'city_id' => $city->id, // Ab ye kabhi NULL nahi hoga
            'name'    => 'Vendor Restaurant',
            'address' => '123 Main St, New York, NY',
        ]);
    }
}