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
        return $this->belongsToMany(Officer::class, 'ltype_officer', 'ltype_id', 'officer_id');
    }
}
