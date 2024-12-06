<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'license_id'];

    public function license()
    {
        return $this->belongsTo(LType::class, 'license_id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'officer_id');
    }
}
