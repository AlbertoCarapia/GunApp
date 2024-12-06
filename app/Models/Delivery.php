<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = ['record_id', 'date'];

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
