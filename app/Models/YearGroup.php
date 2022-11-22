<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearGroup extends Model
{
    use HasFactory;

    protected $guarded      = [];

    protected $primaryKey   = 'year_group';
    protected $keyType      = 'string';
    public    $timestamps   = false;
}
