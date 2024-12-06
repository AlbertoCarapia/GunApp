<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = ['officer_id', 'weapon_id', 'magazine_id', 'issue_date', 'return_date'];

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_id');
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }

    public function magazine()
    {
        return $this->belongsTo(Magazine::class, 'magazine_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'record_id');
    }
}

