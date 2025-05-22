<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teamsize',
    ];

    /**
     * Get the teams for the tournament.
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
