<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tournament_id',
    ];

    /**
     * Get the tournament that owns the team.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
