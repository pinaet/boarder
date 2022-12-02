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
        return $this->belongsTo(Attendance::class,'attendance_id');
    }

    public function register_column()
    {
        return $this->belongsTo(RegisterColumn::class);
    }

    public function registered_by_user()
    {
        return $this->belongsTo(User::class,'registered_by');
    }

    public function noted_by_user()
    {
        return $this->belongsTo(User::class,'noted_by');
    }

}
