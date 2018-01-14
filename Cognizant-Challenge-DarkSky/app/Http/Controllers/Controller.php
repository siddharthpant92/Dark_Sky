<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DatePeriod;
use DateInterval;
use DateTime;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Dark Sky API key
    private $key = "88490773836e03f0b8fa8e4d0511e6d2";

    public function index($place)
    {
    	if($place === "Boulder")
        {
        	$latitude = 40.016457;
        	$longitude = -105.285884;
        }
        elseif ($place === "India")
        {
            $latitude = 12.981000;
            $longitude = 77.66328;
        }
        elseif($place === "Australia")
        {
            $latitude = -37.818721;
            $longitude = 144.959246;
        }
        else
        {
            $latitude = 51.519270;
            $longitude = -0.181799;
        }

    	$forecast = $this->getWeather($latitude, $longitude);

    	//Setting up based on the icon type
    	list($icon_type, $type) = $this->getIconType($forecast->currently->icon);
    	
    	//Constructing object to get the time and weather after 12hours, 24hours, 36hours, 48hours;
    	$hourly = $this->getHourlyData($forecast->hourly->data, $place);

        //Constructing object to get the time and weather for each day in the next week;
        $daily =  $this->getDailyData($forecast->daily->data, $place);

       	return view("home", [ 
    		"forecast"=>$forecast,
    		"type"=>$type,
    		"icon_type"=>$icon_type,
    		"hourly"=>$hourly,
            "daily"=>$daily,
            "place"=>$place]);
    }


    public function timeMachine($date1 = null, $date2 = null)
    {
        $counter = 0;
        
        //For Boulder only
        $latitude = 40.016457;
        $longitude = -105.285884;
        
        if(empty($date1) and empty($date2))
        {
            $timeMachineData = null;
        }
        // Calculated date range.
        else
        {
            //Getting the difference in days
            $numDays = abs($date1 - $date2)/60/60/24;
            for ($i = 0; $i <= $numDays; $i++) 
            {
                // echo date('d M Y', strtotime("+{$i} day", $date1)) . '<br />';
                $date = date('d M Y', strtotime("+{$i} day", $date1));
                $timeMachineData[$counter]['timestamp'] = strtotime($date);
                $timeMachineData[$counter]['date'] = $date;
                $counter++;
            }

            // dd($timeMachineData);

            // Make API call for each??
            $counter = 0;
            foreach ($timeMachineData as $data) 
            {
                // echo $data['timestamp'];
                $forecast = $this->getWeather($latitude, $longitude, $data['timestamp']);
                $timeMachineData[$counter]['summary'] = $forecast->daily->data[0]->summary;
                
                list($icon_type, $type) = $this->getIconType($forecast->daily->data[0]->icon);
                $timeMachineData[$counter]['icon'] = $forecast->daily->data[0]->icon;
                $timeMachineData[$counter]['icon_type'] = $icon_type;
                $timeMachineData[$counter]['type'] = $type;
                $timeMachineData[$counter]['temperatureHigh'] = round($forecast->daily->data[0]->temperatureHigh);
                $timeMachineData[$counter]['temperatureHighCelsius'] = round(($forecast->daily->data[0]->temperatureHigh-32)*5/9);
                $timeMachineData[$counter]['temperatureLow'] = round($forecast->daily->data[0]->temperatureLow);
                $timeMachineData[$counter]['temperatureLowCelsius'] = round(($forecast->daily->data[0]->temperatureLow-32)*5/9);
                $timeMachineData[$counter]['humidity'] = $forecast->daily->data[0]->humidity;
                $timeMachineData[$counter]['windSpeed'] = $forecast->daily->data[0]->windSpeed;
                $counter++;
                // dd($data);
                //Add fields to timeMachineData
            }

            // dd($timeMachineData);

        }
        
        return view("timeMachine", 
            [
                "timeMachineData"=>$timeMachineData
            ]);
    }










    public function getWeather($latitude, $longitude, $timestamp = null)
    {
        if(!$timestamp)
        {
    	   $api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude";
        }
        else
        {
            $api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude, $timestamp";
        }

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
                elseif (strpos($icon, 'day') !== false) 
                {
                    $icon_type = "wi wi-night-clear";
                    $type = "night-clear";       
                }
                elseif (strpos($icon, 'wind') !== false) 
                {
                    $icon_type = "wi wi-cloudy-windy";
                    $type = "cloud";       
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

    public function getHourlyData($data, $place)
    {
    	// dd($data);
    	$count = 0;
    	foreach ($data as $hour) 
    	{

            //Time is in UTC which has to be converted
            if($place === "Boulder")
            {
                //Subtracting 7 hours
                $hourObject["$count"]['time'] = date("d M @ H:i", $hour->time - 60*60*7);
            }
            elseif ($place === "India")
            {
                //Adding 5hr 30min
                $hourObject["$count"]['time'] = date("d M @ H:i", $hour->time + 60*60*5 + 60*30);
            }
            elseif($place === "Australia")
            {
               //Adding 11hr
                $hourObject["$count"]['time'] = date("d M @ H:i", $hour->time + 60*60*11);
            }
            else
            {
                //London time is same as UTC
                $hourObject["$count"]['time'] = date("d M @ H:i", $hour->time);
            }


    		$hourObject["$count"]['summary'] = $hour->summary;
    		$hourObject["$count"]['temperature'] = round($hour->temperature);
            $hourObject["$count"]['temperatureCelsius'] = round(($hour->temperature-32)*5/9);

    		list($icon_type, $type) = $this->getIconType($hour->icon);

    		$hourObject["$count"]['icon'] = $icon_type;
    		$count ++;
    	}
    	// dd($hourObject);
    	return $hourObject;
    }


    public function getDailyData($data, $place = null)
    {
        // dd($data);
        $count = 0;
        foreach ($data as $day) 
        {
            //Time is in UTC which has to be converted
            if($place === "Boulder")
            {
                //Subtracting 7 hours
                $dayObject["$count"]['time'] = date("D, d M", $day->time - 60*60*7);
            }
            elseif ($place === "India")
            {
                //Adding 5hr 30min
                $dayObject["$count"]['time'] = date("D, d M", $day->time - 60*60*5 + 60*30);
            }
            elseif($place === "Australia")
            {
                //Adding 11hr
                $dayObject["$count"]['time'] = date("D, d M", $day->time + 60*60*11);
            }
            else
            {
                //London time is same as UTC
                $dayObject["$count"]['time'] = date("D, d M", $day->time);
            }


            $dayObject["$count"]['summary'] = $day->summary;
            $dayObject["$count"]['temperatureHigh'] = round($day->temperatureHigh);
            $dayObject["$count"]['temperatureHighCelsius'] = round(($day->temperatureHigh-32)*5/9);
            $dayObject["$count"]['temperatureLow'] = round($day->temperatureLow);
            $dayObject["$count"]['temperatureLowCelsius'] = round(($day->temperatureLow-32)*5/9);
            $dayObject["$count"]['sunrise'] = date("H:i", $day->sunriseTime - 60*60*7);
            $dayObject["$count"]['sunset'] = date("H:i", $day->sunsetTime - 60*60*7);
            $dayObject["$count"]['humidity'] = $day->humidity;
            $dayObject["$count"]['windSpeed'] = $day->windSpeed;

            list($icon_type, $type) = $this->getIconType($day->icon);

            $dayObject["$count"]['icon'] = $icon_type;
            $count ++;
        }
        // dd($dayObject);
        return $dayObject;
    }
}
