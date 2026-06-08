<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'identity_card_number',
        'status',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
