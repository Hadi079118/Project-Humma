<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'console_id',
        'user_id',
        'start_time',
        'end_time_planned',
        'end_time_actual',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time_planned' => 'datetime',
        'end_time_actual' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function console()
    {
        return $this->belongsTo(Console::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(RentalDetail::class);
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'rental_details');
    }
}
