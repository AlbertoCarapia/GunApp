<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function officers()
    {
        return $this->hasMany(Officer::class, 'license_id');
    }
}
