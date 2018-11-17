<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
	private $key;

	public function __construct()
	{
		$this->key = env("DARK_SKY_KEY");
	}

	/**
	 * @param  $latitude [The latitude of the selected place]
	 * @param  $longitude [The longitude of the selected place]
	 * @param  $timestamp [The UNIX timestamp which is required only for the timeMachine data]
	 * @return $forecast [An Object which contains all the weather date received by the Dark Sky API call]
	 */
	public function getWeather($latitude, $longitude, $timestamp = null)
	{
		if(!$timestamp)
		{
			//Normal weather API url
		   $api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude";
		}
		else
		{
			//Time Machine API url
			$api = "https://api.darksky.net/forecast/".$this->key."/$latitude, $longitude, $timestamp";
		}

		$forecast = json_decode(file_get_contents($api));

		return $forecast;
	}
}
