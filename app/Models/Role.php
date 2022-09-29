<?php

namespace App\Models;

use App\Models\User;
use App\Models\RolePermission;
use App\Models\PermissionContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permission_contents()
    {
        return $this->hasManyThrough(PermissionContent::class, RolePermission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
