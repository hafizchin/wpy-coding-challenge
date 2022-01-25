<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Collection;
use App\Models;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

#api info
Route::any("/", function(){
    #die("API Usage");
    $usage = <<<txt
<u><b>API Usage</b></u><br><br>
&nbsp;&nbsp;&nbsp;<a href="">/api/population/{city}</a> - returns then population of a city<br>
&nbsp;&nbsp;&nbsp;<a href="">/api/vehicles/{street}</a> - returns all the vehicles in a street<br>
&nbsp;&nbsp;&nbsp;<a href="">/api/vehicle-owners/{license_plate}</a> - returns then owner information of vehicle<br>
&nbsp;&nbsp;&nbsp;<a href="">/api/person-info/{name}</a> - returns then street and address of a person<br>
txt;
    return response($usage)
            ->withHeaders([
                'Content-Type' => 'text/html'
            ]);
});

#all people living in your city
Route::any("/population/{city?}", function($city = null){
    $result = [
        "query"  => "city-population",
        "param"  => $city,
        "result" => App\Models\City::getPopulation($city)
    ];
    return response()->json($result);
});

#fetch all cars when providing a particular street name
Route::any("/vehicles/{street?}", function($street){
    $result = [
        "query"  => "vehicles-in-street",
        "param"  => $street,
        "result" => App\Models\Street::getCars($street)
    ];
    return response()->json($result);
});

#fetch the owner(s) of a vehicle when providing a license plate
Route::any("/vehicle-owners/{license_plate}", function($license_plate){
    $result = [
        "query"  => "vehicle-owners",
        "param"  => $license_plate,
        "result" => App\Models\Car::getOwners($license_plate)
    ];
    return response()->json($result);
});

#fetch the full address and street of a house when providing a person's name
Route::any("/person-info/{name}", function($name){
    $result = [
        "query"  => "person-info",
        "param"  => $name,
        "result" => App\Models\Resident::getAddress($name)
    ];
    return response()->json($result);
});