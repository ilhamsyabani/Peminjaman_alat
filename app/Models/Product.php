<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $sortable = ['id', 'name','location.name', 'status', 'created_at', 'updated_at'];


    public function transactionItem()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class, 'locker_id');
    }
}
