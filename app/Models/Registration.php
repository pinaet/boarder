<?php

namespace App\Models;

use App\Models\User;
use App\Models\Boarder;
use App\Models\Attendance;
use App\Models\RegisterColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function boarder()
    {
        return $this->belongsTo(Boarder::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function register_column()
    {
        return $this->belongsTo(RegisterColumn::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class);
    }

}
