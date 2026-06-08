<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'game_id',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
