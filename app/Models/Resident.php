<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;
    protected $table = 'resident';

    public function street()
    {
         return $this->hasOneThrough(
            Street::class,
            House::class,
            'street_id',
            'id',
        );
    }

    public function house()
    {
         return $this->hasOneThrough(
            House::class,
            Street::class,
            'id',
            'street_id',
        );
    }

    public static function getAddress($name = null)
    {
        $residents = self::where("name", $name)->get();
        $return    = [];

        foreach($residents as $resident)
        {
            return [
                "street"  => $resident->street->name,
                "address" => $resident->house->address
            ];
        }

        return $return;
    }
}
