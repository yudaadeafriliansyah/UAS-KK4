<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'motor_id',
        'user_id',
        'transaction_code',
        'nama',
        'email',
        'nomer_hp',
        'alamat',
        'nomer_identitas',
        'gambar_sim',
        'date_start',
        'date_end',
        'people',
        'transaction_total',
        'transaction_status',
    ];

    // relasi. 1 motor bisa punya banyak transaksi di hasil postmannya
    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
