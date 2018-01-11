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
    	// $test = [];
    	// $test['name'] = "Sid";
    	// $test['age'] = "25";
    	// $test['color'] = "red";

    	// $test['color'] = "nlue";
    	// dd($test);

    	$latitude = 40.016457;
    	$longitude = -105.285884;

    	$forecast = $this->getWeather($latitude, $longitude);

    	//Setting up based on the icon type

    	list($icon_type, $type) = $this->getIconType($forecast->currently->icon);
    	
    	//Constructing object to get the time and weather after 12hours, 24hours, 36hours, 48hours;
    	$hourly = $this->getHourlyData($forecast->hourly->data);


        $daily =  $this->getDailyData($forecast->daily->data);

       	return view("home", [ 
    		"forecast"=>$forecast,
    		"type"=>$type,
    		"icon_type"=>$icon_type,
    		"hourly"=>$hourly,
            "daily"=>$daily]);
    }

    public function getWeather($latitude, $longitude)
    {
    	$api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude";

    	$forecast = json_decode(file_get_contents($api));

    	return $forecast;
    }

    public function getIconType($icon)
    {
    	switch($icon)
    	{
    		case "clear-day":
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
                if (strpos($icon, 'night') !== false) 
                {
                    $icon_type = "wi wi-night-clear";
                    $type = "night-clear";       
                }
                if (strpos($icon, 'day') !== false) 
                {
                    $icon_type = "wi wi-night-clear";
                    $type = "night-clear";       
                }
                else
                {
                    $icon_type = "wi wi-day-cloudy";
                    $type = "cloud";
                }
    			break;
    	}

    	return array($icon_type, $type);
    }

    public function getHourlyData($data)
    {
    	// dd($data);
    	$count = 0;
    	foreach ($data as $hour) 
    	{
    		$hourObject["$count"]['time'] = date("d M @ H:i", $hour->time);

    		$hourObject["$count"]['summary'] = $hour->summary;
    		$hourObject["$count"]['temperature'] = $hour->temperature;

    		list($icon_type, $type) = $this->getIconType($hour->icon);

    		$hourObject["$count"]['icon'] = $icon_type;
    		$count ++;
    	}
    	// dd($hourObject);
    	return $hourObject;
    }


    public function getDailyData($data)
    {
        // dd($data);
        $count = 0;
        foreach ($data as $day) 
        {
            $dayObject["$count"]['time'] = date("d M @ H:i", $day->time);

            $dayObject["$count"]['summary'] = $day->summary;
            $dayObject["$count"]['temperatureHigh'] = $day->temperatureHigh;
            $dayObject["$count"]['temperatureLow'] = $day->temperatureLow;
            $dayObject["$count"]['sunrise'] = date("d M @ H:i", $day->sunriseTime);
            $dayObject["$count"]['sunset'] = date("d M @ H:i", $day->sunsetTime);

            list($icon_type, $type) = $this->getIconType($day->icon);

            $dayObject["$count"]['icon'] = $icon_type;
            $count ++;
        }
        dd($dayObject);
        return $dayObject;
    }
}
