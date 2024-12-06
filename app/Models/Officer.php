<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'license_id'];

    public function licenses()
    {
        return $this->belongsToMany(LType::class, 'ltype_officer', 'officer_id', 'ltype_id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'officer_id');
    }
}
