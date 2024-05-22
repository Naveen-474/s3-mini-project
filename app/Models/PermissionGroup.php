<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends Model
{
    use HasFactory;

    /**
     * Build a relationship with permission model.
     *
     * @return HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
