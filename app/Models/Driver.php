<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transportation_id'
    ];

    /**
     * Get tranportation
     */
    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }

    /**
     * Get user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'role');
    }
}
