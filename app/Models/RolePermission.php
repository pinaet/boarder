<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\PermissionContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
        $table->foreignId('role_id')->constrained();
        $table->foreignId('permission_content_id')->constrained();
        $table->string('permission'); //v,u,d
    */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission_content()
    {
        return $this->belongsTo(PermissionContent::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class);
    }
}
