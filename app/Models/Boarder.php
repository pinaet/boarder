<?php

namespace App\Models;

use App\Models\Contact;
use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boarder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }

    public function building()
    {
        return $this->hasOne(Building::class, 'id', 'building_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'pupil_id', 'pupil_id');
    }
}
