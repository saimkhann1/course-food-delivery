<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminRole();
    }
    protected function createRole(RoleName $roleName, Collection $permissions): void
    {
        $newRole = Role::create(['name' => $roleName->value]);
        $newRole->permissions()->sync($permissions);
    }

    protected function createAdminRole(): void
    {
        $permissions = Permission::query()
        ->where('name','like','user.%')
        ->orWhere('name','like','restaurant.%')
        ->pluck('id');
        $this->createRole(RoleName::ADMIN, $permissions);
    }

}
