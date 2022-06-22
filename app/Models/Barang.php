<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        });

        $query->when($filters['location'] ?? false, function ($query, $location) {
            return $query->whereHas('location', function ($query) use ($location) {
                $query->where('id', $location);
            });
        });

        $query->when($filters['room'] ?? false, function ($query, $room) {
            return $query->whereHas('room', function ($query) use ($room) {
                $query->where('id', $room);
            });
        });
    }


    public function transaction()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class);
    }
}
