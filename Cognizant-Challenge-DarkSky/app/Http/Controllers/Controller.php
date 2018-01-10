<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Dark Sky API key
    private $key = "88490773836e03f0b8fa8e4d0511e6d2";

    public function index()
    {
    	// var $icon_type;

    	$latitude = 40.016457;
    	$longitude = -105.285884;
    	// $test = [];
    	// $test['name'] = "Sid";
    	// $test['age'] = "25";
    	// $test['color'] = "red";

    	$forecast = $this->getWeather($latitude, $longitude);

    	//Setting up based on the icon type
    	switch($forecast->currently->icon)
    	{
    		// case "clear-day":
    			$icon_type = "wi wi-day-sunny";
    			$type = "day-sunny";
    			break;
    		case "clear-night":
    			$icon_type = "wi wi-night-clear";
    			$type = "night-clear";
    			break;
    		case "rain":
    			$icon_type = "wi wi-rain";
    			$type = "rain";
    			break;
    		case "snow":
    			$icon_type = "wi wi-snow";
    			$type = "snow";
    			break;
    		case "partly-cloudy-day":
    			$icon_type = "wi wi-day-cloudy";
    			$type = "cloud";
    			break;
    		default:
    			$icon_type = "wi wi-day-cloudy";
    			$type = "cloud";
    			break;
    	}

    	return view("home", [ 
    		"forecast"=>$forecast,
    		"type"=>$type,
    		"icon_type"=>$icon_type]);
    }

    public function getWeather($latitude, $longitude)
    {
    	$api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude";

    	$forecast = json_decode(file_get_contents($api));
    	return $forecast;
    }
}
