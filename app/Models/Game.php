<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'platform',
        'genre',
        'release_year',
        'status',
    ];

    public function rentalDetails()
    {
        return $this->hasMany(RentalDetail::class);
    }

    public function rentals()
    {
        return $this->belongsToMany(Rental::class, 'rental_details');
    }
}
