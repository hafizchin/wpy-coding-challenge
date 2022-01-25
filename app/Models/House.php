<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $table = 'house';
 
    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
