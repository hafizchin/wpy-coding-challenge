<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    protected $table = 'street';

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public static function getCars($street = null)
    {
        $streets = self::where("name", $street)->get();
        $return  = [];

        foreach($streets as $index => $street)
        {
            
            foreach($street->houses as $houses)
            {
                $return[] = $houses->cars->makeHidden("id")->makeHidden("house_id")->toArray()[0];
            }
        }

        return $return;
    }
}
