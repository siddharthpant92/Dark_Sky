<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Weather as Weather;

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
			$weather = new Weather();
			$timeMachineData = $weather->parseTimeMachineData($date1, $date2, $latitude, $longitude);
		}

		return view("timeMachine", 
		[
			"timeMachineData"=>$timeMachineData
		]);
	}
}
