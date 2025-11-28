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
        $this->createVendorRole();
        $this->createCustomerRole();
        $this->createStaffRole();
    }
    protected function createRole(RoleName $roleName, Collection $permissions): void
    {
        $newRole = Role::create(['name' => $roleName->value]);
        $newRole->permissions()->sync($permissions);
    }

    protected function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'user.%')
            ->orWhere('name', 'like', 'restaurant.%')
            ->pluck('id');
        $this->createRole(RoleName::ADMIN, $permissions);
    }
    protected function createVendorRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'category.%')
            ->orWhere('name', 'like', 'product.%')
            ->orwhereIn('name', [
                'user.create',
                'user.viewAny',
                'user.delete',
            ]);
        $this->createRole(RoleName::VENDOR, $permissions->pluck('id'));
    }
    public function createCustomerRole(): void
    {
        $permissions = Permission::whereIn('name', [
            'cart.add',
            'order.viewAny',
            'order.create',
        ])->get();
        $this->createRole(RoleName::CUSTOMER, $permissions);
    }
    public function createStaffRole(): void
    {
        $this->createRole(RoleName::STAFF, collect());
    }
}
