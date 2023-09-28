<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'name'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }
}
