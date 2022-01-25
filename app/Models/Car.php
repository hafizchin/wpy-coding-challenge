<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    use HasFactory;
    protected $table = 'car';

    public function owners()
    {
        return $this->hasManyThrough(
            Resident::class,
            House::class,
            'id',
            'house_id'
        );
    }

    public static function getOwners($license_plate = null)
    {
        $cars   = self::where("license_plate", $license_plate)->get();
        $return = [];

        foreach($cars as $car)
        {
            foreach($car->owners as $owner)
            {
                //assuming only >=18 can own a car
                if($owner->age >= 18)
                {
                   $return[] = $owner->name;
                }
           }
        }

        return $return;
    }
}
