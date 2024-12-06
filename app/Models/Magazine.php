<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'weapon_id', 'in_stock'];

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }
}
