<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type_id', 'in_stock'];

    public function type()
    {
        return $this->belongsTo(WeaponType::class, 'type_id');
    }

    public function magazines()
    {
        return $this->hasMany(Magazine::class, 'weapon_id');
    }
}
