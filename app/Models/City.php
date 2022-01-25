<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';

    public function streets()
    {
        return $this->hasMany(Street::class);
    }

    public static function getPopulation($city = null)
    {
        if (strtolower($city) == 'all')
        {
            $cities = self::orderBy("name", "asc")->get();
        }
        else
        {
            $cities = self::where("name", $city)->orderBy("name", "asc")->get();
        }

        
        $return = [];
        
        foreach($cities as $index => $city)
        {
            $return[$index] = ["city" => $city->name, "population" => 0];

            foreach($city->streets as $street)
            {
                foreach($street->houses as $house)
                {
                    $return[$index]["population"] += count($house->residents->toArray());
                }
            }
        }

        return $return;
    }
}