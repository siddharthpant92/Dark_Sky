<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $key;

    public function __construct()
    {
        $this->key = env("DARK_SKY_KEY");
    }

    public function index()
    {
    	$latitude = 40.016457;
    	$longitude = -105.285884;
    	// $test = [];
    	// $test['name'] = "Sid";
    	// $test['age'] = "25";
    	// $test['color'] = "red";

    	$forecast = $this->getWeather($latitude, $longitude);

    	//Do a switch on the icon and create an object with certain colors codes and styles to be sent to home.blade. then they can be accessed and used for styling throughout the page


    	return view("home", [ 
    		"forecast"=>$forecast]);
    }

    public function getWeather($latitude, $longitude)
    {
    	$api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude";

    	$forecast = json_decode(file_get_contents($api));
    	return $forecast;
    }
}
