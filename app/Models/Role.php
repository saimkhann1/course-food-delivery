<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function Permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
