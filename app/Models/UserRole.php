<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
        $table->foreignId('user_id')->constrained();
        $table->foreignId('role_id')->constrained();
        $table->foreignId('created_by')->constrained();
        $table->foreignId('updated_by')->constrained();
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(user::class, 'id', 'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }
}
