<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('barang', function ($query) use ($search) {
                $query->where('nama', $search);
            });
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            return $query->where('status', $status);
        });


        // $query->when($filters['room'] ?? false, function ($query, $room) {
        //     return $query->whereHas('room', function ($query) use ($room) {
        //         $query->where('id', $room);
        //     });
        // });
    }
}
