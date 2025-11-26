<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use App\Models\RoleName;
use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function restaurant(): HasOne
    {
        return $this->hasOne(Restaurant::class, 'owner_id');
    }
    public function Roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function isAdmin()
    {
        return $this->hasRole(RoleName::ADMIN);
    }
    public function isVendor()
    {
        return $this->hasRole(RoleName::VENDOR);
    }
    public function isStaff()
    {
        return $this->hasRole(RoleName::STAFF);
    }
    public function isCustomer()
    {
        return $this->hasRole(RoleName::CUSTOMER);
    }
    public function hasRole(RoleName $roleName): bool
    {
        return $this->Roles()->where('name', $roleName->value)->exists();
    }
    public function permissions()
    {
        return $this->Roles()->with('Permissions')->get()->map(function ($role) {
            return $role->Permissions->pluck('name');
        })
            ->flatten()->values()->unique()->toArray();
    }
    public function hasPermission(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissions());
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
