<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Weather as Weather;
use DatePeriod;
use DateInterval;
use DateTime;

class Controller extends BaseController
{
	//Dark Sky API key
	private $key;

	public function __construct()
	{
		$this->key = env("DARK_SKY_KEY");
	}

	/**
	 * @param  $place [The place the user has selected to view the weather conditions for]
	 * @return [view] [Returns the view which shows the weather forecase for the selected place]
	 */
	public function index($place)
	{
		//Initializing the latitude and longitude based on the place the user selected
		if($place === "Boulder")
		{
			$latitude = 40.016457;
			$longitude = -105.285884;
		}
		elseif($place === "Bangalore")
		{
			$latitude = 12.981000;
			$longitude = 77.66328;
		}
		elseif($place === "Melbourne")
		{
			$latitude = -37.818721;
			$longitude = 144.959246;
		}
		else //London
		{
			$latitude = 51.519270;
			$longitude = -0.181799;
		}

		$weather = new Weather();

		//An object which holds all the weather data after the API call
		$forecast = $weather->getWeather($latitude, $longitude);

		list($type, $icon_type, $hourly, $daily) = $weather->parseWeatherData($forecast, $place);

		return view("home", [ 
			"forecast"=>$forecast,
			"type"=>$type,
			"icon_type"=>$icon_type,
			"hourly"=>$hourly,
			"daily"=>$daily,
			"place"=>$place]);
	}

	/**
	 * @param  $date1 [The starting date of the date range the user selected]
	 * @param  $date2 [The ending date of the date range the user selected]
	 * @return [view] [A view with the weather data for the date range selected by the user]
	 */
	public function timeMachine($date1 = null, $date2 = null)
	{
		$counter = 0;
		
		//For Boulder only
		$latitude = 40.016457;
		$longitude = -105.285884;
		
		//The first time the user lands here, there is no date range selected
		if(empty($date1) and empty($date2))
		{
			$timeMachineData = null;
		}
		// Calculate date range and get weather data for each day in that range
		else
		{
			//Getting the difference between the dates in days
			$numDays = abs($date1 - $date2)/60/60/24;
			for ($i = 0; $i <= $numDays; $i++) 
			{
				// echo date('d M Y', strtotime("+{$i} day", $date1)) . '<br />';
				$date = date('d M Y', strtotime("+{$i} day", $date1));
				$timeMachineData[$counter]['timestamp'] = strtotime($date);
				$timeMachineData[$counter]['date'] = $date;
				$counter++;
			}

		   $weather = new Weather();

			// Make API call for each timestamp and add the data to a new object
			$counter = 0;
			foreach ($timeMachineData as $data) 
			{
				$forecast = $weather->getWeather($latitude, $longitude, $data['timestamp']);

				//Checking if respective data points exist, if not then setting defailt values
				if(!isset($forecast->daily->data[0]->summary))
				{
					$timeMachineData[$counter]['summary'] = "No summary";
				}
				else
				{
					$timeMachineData[$counter]['summary'] = $forecast->daily->data[0]->summary;
				}

				if(!isset($forecast->daily->data[0]->sunriseTime))
				{
					$timeMachineData[$counter]['sunrise'] = "N/A";
				}
				else
				{
					//Time is un UTC, so subtracting 7 hours to get MST
					$timeMachineData[$counter]['sunrise'] = date("H:i", $forecast->daily->data[0]->sunriseTime - 60*60*7);
				}

				if(!isset($forecast->daily->data[0]->sunsetTime))
				{
					$timeMachineData[$counter]['sunset'] = "N/A";
				}
				else
				{
					//Time is un UTC, so subtracting 7 hours to get MST
					$timeMachineData[$counter]['sunset'] = date("H:i", $forecast->daily->data[0]->sunsetTime - 60*60*7);
				}
				

				if(!isset($forecast->daily->data[0]->icon))
				{
					$timeMachineData[$counter]['icon'] = "cloudy";
					$timeMachineData[$counter]['icon_type'] = "wi wi-cloudy";
					$timeMachineData[$counter]['type'] = "cloud"; 
				}
				else
				{
					list($icon_type, $type) = $this->getIconType($forecast->daily->data[0]->icon);
					$timeMachineData[$counter]['icon'] = $forecast->daily->data[0]->icon;
					$timeMachineData[$counter]['icon_type'] = $icon_type;
					$timeMachineData[$counter]['type'] = $type;    
				}

				if(!isset($forecast->daily->data[0]->temperatureHigh))
				{
					$timeMachineData[$counter]['temperatureHigh'] = "N/A";
					$timeMachineData[$counter]['temperatureHighCelsius'] = "N/A";
				}
				else
				{
					$timeMachineData[$counter]['temperatureHigh'] = round($forecast->daily->data[0]->temperatureHigh);
					$timeMachineData[$counter]['temperatureHighCelsius'] = round(($forecast->daily->data[0]->temperatureHigh-32)*5/9);
				}
			   
				if(!isset($forecast->daily->data[0]->temperatureLow))
				{
					$timeMachineData[$counter]['temperatureLow'] = "N/A";
					$timeMachineData[$counter]['temperatureLowCelsius'] = "N/A";
				}
				else
				{
					$timeMachineData[$counter]['temperatureLow'] = round($forecast->daily->data[0]->temperatureLow);
					$timeMachineData[$counter]['temperatureLowCelsius'] = round(($forecast->daily->data[0]->temperatureLow-32)*5/9);
				}

				if(!isset($forecast->daily->data[0]->humidity))
				{
					$timeMachineData[$counter]['humidity'] = "N/A";
				}
				else
				{
					$timeMachineData[$counter]['humidity'] = $forecast->daily->data[0]->humidity;    
				}
				
				if(!isset( $forecast->daily->data[0]->windSpeed))
				{
					$timeMachineData[$counter]['windSpeed'] = "N/A";
				}
				else
				{
					$timeMachineData[$counter]['windSpeed'] = $forecast->daily->data[0]->windSpeed;    
				}
				
				$counter++;
			}
		}
	   
		return view("timeMachine", 
		[
			"timeMachineData"=>$timeMachineData
		]);
	}
}
