<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * Get user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'role');
    }
}
