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
	
		//Setting up based on the icon type
		if(!isset($forecast->currently->icon) || !isset($forecast->currently)) //If 'currently' data point doesn't even exist
		{
			$icon_type = "wi wi-cloudy";
			$type = "cloud";
		}
		else
		{
		   list($icon_type, $type) = $this->getIconType($forecast->currently->icon);
		}
		
		//Constructing object to get the time and weather after 12hours, 24hours, 36hours, 48hours
		if(!isset($forecast->hourly->data) || !isset($forecast->hourly)) //If hourly data point doesn't even exist
		{
			//$hourly is the object being passed to the view
			$hourly[0]['time'] = "No date available";
			$hourly[0]['summary'] = "No summary available";
			$hourly[0]['temperature'] = "N/A";
			$hourly[0]['temperatureCelsius'] = "N/A";
			$hourly[0]['icon'] = "wi wi-cloudy";
		}
		else
		{
		   $hourly = $this->getHourlyData($forecast->hourly->data, $place);
		}

		//Constructing object to get the time and weather for each day in the next week
		if(!isset($forecast->daily->data) || !isset($forecast->daily)) //If daily data point doesn't even exist
		{
			//$daily is the object being passed to the view
			$daily[0]['time'] = "No date available";
			$daily[0]['summary'] = "No summary available";
			$daily[0]['temperatureHigh'] = "N/A";
			$daily[0]['temperatureHighCelsius'] = "N/A";
			$daily[0]['temperatureLow'] = "N/A";
			$daily[0]['temperatureLowCelsius'] = "N/A";
			$daily[0]['sunrise'] = "N/A";
			$daily[0]['sunset'] = "N/A";
			$daily[0]['humidity'] = "N/A";
			$daily[0]['windSpeed'] = "N/A";
			$daily[0]['icon'] = "N/A";
		}
		else
		{
			$daily =  $this->getDailyData($forecast->daily->data, $place);
		}

		list($forecast, $type, $icon_type, $hourly, $daily, $place) = $weather->parseWeatherData($forecast);

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


	/**
	 * @param  $icon [The value of the 'icon' datapoint received from the API call]
	 * @return [array] [An array which contains the class name for the required weather icon, and the type which decides which color theme to be used in the view]
	 */
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
			case "sleet":
				$icon_type = "wi wi-sleet";
				$type = "snow";
				break;
			case "wind":
				$icon_type = "wi wi-strong-wind";
				$type = "cloud";
				break;
			case "fog":
				$icon_type = "wi wi-fog";
				$type = "cloud";
				break;
			case "cloudy":
				$icon_type = "wi wi-cloudy";
				$type = "cloud";
				break;
			case "partly-cloudy-day":
				$icon_type = "wi wi-day-cloudy";
				$type = "cloud";
				break;
			case "partly-cloudy-night":
				$icon_type = "wi wi-night-cloudy-high";
				$type = "night-clear";
				break;
			default: //Since future icons include hail, thunderstorm and tornado
				$icon_type = "wi wi-rain";
				$type = "rain";
				break;
		}

		return array($icon_type, $type);
	}

	/**
	 * @param  $data [An object which contains the hourly data received from the Dark Sky API call]
	 * @param  $place [The place the user selected]
	 * @return hourObject12Hour [An object which contains the weather data for the intervals of 12, 24, 36 and 48 hours]
	 */
	public function getHourlyData($data, $place)
	{
		$count = 0;
		foreach ($data as $hour) 
		{
			if(!isset($hour->time))
			{
				$hourObject["$count"]['time'] = "No date-time available";
			}
			else
			{
				//Time is in UTC which has to be converted
				if($place === "Boulder")
				{
					//Subtracting 7 hours
					$hourObject["$count"]['time'] = date("d M @ H:i", $hour->time - 60*60*7);
				}
				elseif ($place === "Bangalore")
				{
					//Adding 5hr 30min
					$hourObject["$count"]['time'] = date("d M @ H:i", $hour->time + 60*60*5 + 60*30);
				}
				elseif($place === "Melbourne")
				{
				   //Adding 11hr
					$hourObject["$count"]['time'] = date("d M @ H:i", $hour->time + 60*60*11);
				}
				else
				{
					//London time is same as UTC
					$hourObject["$count"]['time'] = date("d M @ H:i", $hour->time);
				}
			}

			if(!isset($hour->summary))
			{   
				$hourObject["$count"]['summary'] = "No summary available";
			}
			else
			{
				$hourObject["$count"]['summary'] = $hour->summary;
			}

			if(!isset($hour->temperature))
			{
				$hourObject["$count"]['temperature'] = "N/A";
				$hourObject["$count"]['temperatureCelsius'] = "N/A";
			}
			else
			{
				$hourObject["$count"]['temperature'] = round($hour->temperature);
				$hourObject["$count"]['temperatureCelsius'] = round(($hour->temperature-32)*5/9);
			}
		   
			if(!isset($hour->icon))
			{
				$hourObject["$count"]['icon'] = "wi wi-cloudy";
			}
			else
			{
				list($icon_type, $type) = $this->getIconType($hour->icon);
				$hourObject["$count"]['icon'] = $icon_type;    
			}
			
			$count ++;
		}

		//Since the data is being displayed only for 12 hour intervals, copying those data points into a separate object
		$hourObject12Hour[0]=$hourObject['12'];
		$hourObject12Hour[1]=$hourObject['24'];
		$hourObject12Hour[2]=$hourObject['36'];
		$hourObject12Hour[3]=$hourObject['48'];
		
		// return $hourObject;
		return $hourObject12Hour;
	}

	/**
	 * @param  $data [An object which contains the daily data received from the Dark Sky API call]
	 * @param  $place [The place selected by the user]
	 * @return $dayObject [An object which contains the weather data for each day returned from the Dark Sky API call]
	 */
	public function getDailyData($data, $place)
	{
		$count = 0;

		foreach ($data as $day) 
		{
			if(!isset($day->time))
			{
				$dayObject["$count"]['time'] = "No date-time available";
			}
			else
			{
				//Time is in UTC which has to be converted
				if($place === "Boulder")
				{
					//Subtracting 7 hours
					$dayObject["$count"]['time'] = date("D, d M", $day->time - 60*60*7);
				}
				elseif ($place === "Bangalore")
				{
					//Adding 5hr 30min
					$dayObject["$count"]['time'] = date("D, d M", $day->time + 60*60*5 + 60*30);
				}
				elseif($place === "Melbourne")
				{
					//Adding 11hr
					$dayObject["$count"]['time'] = date("D, d M", $day->time + 60*60*11);
				}
				else
				{
					//London time is same as UTC
					$dayObject["$count"]['time'] = date("D, d M", $day->time);
				}
			}

			if(!isset($day->summary))
			{
				$dayObject["$count"]['summary'] = "No summary available";
			}
			else
			{
				$dayObject["$count"]['summary'] = $day->summary;
			}

			if(!isset($day->temperatureHigh))
			{
				$dayObject["$count"]['temperatureHigh'] = "N/A";
				$dayObject["$count"]['temperatureHighCelsius'] = "N/A";
			}
			else
			{
				$dayObject["$count"]['temperatureHigh'] = round($day->temperatureHigh);
				$dayObject["$count"]['temperatureHighCelsius'] = round(($day->temperatureHigh-32)*5/9);    
			}
			

			if(!isset($day->temperatureLow))
			{
				$dayObject["$count"]['temperatureLow'] = "N/A";
				$dayObject["$count"]['temperatureLowCelsius'] = "N/A";
			}
			else
			{
				$dayObject["$count"]['temperatureLow'] = round($day->temperatureLow);
				$dayObject["$count"]['temperatureLowCelsius'] = round(($day->temperatureLow-32)*5/9);
			}
			

			if(!isset($day->sunriseTime))
			{
				$dayObject["$count"]['sunrise'] = "N/A";
			}
			else
			{
				//Time is in UTC which has to be converted
				if($place === "Boulder")
				{
					//Subtracting 7 hours
					$dayObject["$count"]['sunrise'] = date("H:i", $day->sunriseTime - 60*60*7);
				}
				elseif ($place === "Bangalore")
				{
					//Adding 5hr 30min
					$dayObject["$count"]['sunrise'] = date("H:i", $day->sunriseTime + 60*60*5 + 60*30);
				}
				elseif($place === "Melbourne")
				{
					//Adding 11hr
					$dayObject["$count"]['sunrise'] = date("H:i", $day->sunriseTime + 60*60*11);
				}
				else
				{
					//London time is same as UTC
					$dayObject["$count"]['sunrise'] = date("H:i", $day->sunriseTime);
				} 
			}
			

			if(!isset($day->sunsetTime))
			{
				$dayObject["$count"]['sunset'] = "N/A";
			}
			else
			{
				//Time is in UTC which has to be converted
				if($place === "Boulder")
				{
					//Subtracting 7 hours
					$dayObject["$count"]['sunset'] = date("H:i", $day->sunsetTime - 60*60*7);
				}
				elseif ($place === "Bangalore")
				{
					//Adding 5hr 30min
					$dayObject["$count"]['sunset'] = date("H:i", $day->sunsetTime + 60*60*5 + 60*30);
				}
				elseif($place === "Melbourne")
				{
					//Adding 11hr
					$dayObject["$count"]['sunset'] = date("H:i", $day->sunsetTime + 60*60*11);
				}
				else
				{
					//London time is same as UTC
					$dayObject["$count"]['sunset'] = date("H:i", $day->sunsetTime);
				} 
			}
			

			if(!isset($day->humidity))
			{
				$dayObject["$count"]['humidity'] = "N/A";
			}
			else
			{
				$dayObject["$count"]['humidity'] = $day->humidity;
			}
			

			if(!isset($day->windSpeed))
			{
				 $dayObject["$count"]['windSpeed'] = "N/A";
			}
			else
			{
				$dayObject["$count"]['windSpeed'] = $day->windSpeed;    
			}
		   

			if(!isset($day->icon))
			{
				$dayObject["$count"]['icon'] = "wi wi-cloudy";
			}
			else
			{
				list($icon_type, $type) = $this->getIconType($day->icon);
				$dayObject["$count"]['icon'] = $icon_type;
			}
		   
			$count ++;
		}
		
		return $dayObject;
	}
}
