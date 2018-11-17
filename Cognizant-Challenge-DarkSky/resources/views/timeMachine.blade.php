<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Dark Sky</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		
		<!-- Styles -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="/css/weather-icons.css"/>
		<link rel="stylesheet" type="text/css" href="/css/styles.css" />	

	</head>
	<body id="app" :class="weatherClassBackground">
		<div class="header" :class="weatherClassBtn">
			<a href="{{url('/')}}" class="content" :class="weatherClass">Main page</a>
			<a href="{{route('home', ['place'=>'Boulder'])}}" class="content" :class="weatherClass">Back to the weather forecast page</a>
			<a href="#" v-if="!celsius" @click="celsius = !celsius" class="content" :class="weatherClass">Convert to &deg;C</a>
			<a href="#" v-else @click="celsius = !celsius" class="content" :class="weatherClass">Convert to &deg;F</a>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-2">
						<input type="text" class="subheading btn round" id="datepicker1" v-model="date1" :class="weatherClassBtn">
					</div>
					
					<div class="col-sm-4">
						<input type="text" class="subheading btn round" id="datepicker2" v-model="date2" :class="weatherClassBtn">
					</div>
				</div>
				<div class="row">
					<a :href="url" v-if="d1Selected && d2Selected" @click="show = true" class="subheading btn round" :class="weatherClassBtn">Get the weather for this date range</a>
					<span v-else  class="subheading btn" :class="weatherClass">Go ahead and enter the 2 dates</span>
					<div v-if="show">
						<span class="subheading" :class="weatherClass">Hang on a bit! It takes time to get the weather!</span>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="subheading" :class="weatherClass">
					When the dates and the weather show up, move the mouse over the cards to change the theme based on the forecast of that day!!
					<br>
					<br>
					Boulder
				</div>
				<div v-for="data in timeMachineData" class="border-double card col-sm-3 @{{data.type}} @{{data.type}}-bg" v-on:mouseover="changeTheme(data.type)">
					<p>@{{data.date}}</p>
					<!-- <span>@{{data.icon}}</span> -->
					<i class="@{{data.icon_type}}"></i>
					<br>
					<span> @{{data.summary}}</span>
					<br><br>
					<i class="wi wi-thermometer"></i> 
					<span v-if="!celsius" >@{{data.temperatureLow}}&deg;F - @{{data.temperatureHigh}}&deg;F</span>
					<span v-else> @{{data.temperatureLowCelsius}}&deg;C - @{{data.temperatureHighCelsius}}&deg;C</span>
					<br><br>
					<i class="wi wi-sunrise"></i> @{{data.sunrise}}
					<i class="wi wi-sunset"></i> @{{data.sunset}}
					<br><br>
					<i class="wi wi-humidity"></i><span> @{{data.humidity}}</span>
					<br><br>
					<i class="wi wi-strong-wind"></i><span> @{{data.windSpeed}} km/hr</span>
				</div>		
			</div>
		</div>
	</body>
</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
	new Vue(
	{
		el: "#app",
		data:
		{
			celsius: false, //To display the temperature in Celsius(if true) or Farenheit(if false)
			show: false, //To show the div saying data is being fetched
			d1Selected: false, //Set to true when the start date has been selected
			d2Selected: false, //Set to true when the end date has been selected
			date1: 'Select the start date', //The value of the start date
			date2: 'Select the end date', //The value of the end date
			url: '', //The url which displays the weather for the date range, dynamically set based on the dates selected
			timeMachineData: @json($timeMachineData), //An object containing the weather data
			weatherClassBackground: 'day-sunny-bg', //Dynamically set class to change the background color theme
			weatherClass: 'day-sunny', //Dynamically set class to set the general text color theme
			weatherClassBtn: 'day-sunny-btn' //Dynamically set class to set the button color theme
		},
		watch:
		{
			//Checking if the start date has been properly selected
			date1: function()
			{
				var d1 = new Date(this.date1).getTime()/1000;
				var d2 = new Date(this.date2).getTime()/1000;
				if(this.date1 === '' || !d1)
				{
					window.alert('Please enter your start date');
					this.d1Selected = false;
				}
				else
				{
					this.d1Selected = true;
				}
				if(new Date(this.date2) < new Date(this.date1))
				{
					window.alert("End date can't be before the start date!");
					this.date1 = 'Select the start date';
					this.date2 = 'Select the end date';
					this.show = false;
					this.d1Selected = false;
					this.d2Selected = false;
				}
				if(this.d1Selected && this.d2Selected)
				{
					this.url =  "http://localhost:8000/time-machine/"+d1+"/"+d2;
				}
			},
			//Checking if the end date has been properly selected
			date2: function()
			{
				var d1 = new Date(this.date1).getTime()/1000;
				var d2 = new Date(this.date2).getTime()/1000;

				//If the end date has an empty value
				if(this.date2 === '' || !d2)
				{
					window.alert('Please enter your end date');
					this.d2Selected = false;
				}
				else
				{
					this.d2Selected = true;
				}

				//If the end date is before the start date
				if(new Date(this.date2) < new Date(this.date1))
				{
					window.alert("End date can't be before the start date!");
					this.date1 = 'Select the start date';
					this.date2 = 'Select the end date';
					this.show = false;
					this.d1Selected = false;
					this.d2Selected = false;
				}
				
				if(this.d1Selected && this.d2Selected)
				{
					this.url =  "http://localhost:8000/time-machine/"+d1+"/"+d2;
				}
			}
		},
		methods:
		{
			//To change the color theme of the page when the user hovers over the card for the weather forecast for a particular day
			changeTheme: function(type)
			{
				this.weatherClassBackground = type+"-bg";
				this.weatherClass = type;
				this.weatherClassBtn = type+"-btn";
			}
		}
	});

	//3rd party date picker element
	$(function() 
	{
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
	});
</script>
</script>