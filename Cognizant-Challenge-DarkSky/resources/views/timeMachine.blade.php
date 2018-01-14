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
    		<div class="col-sm-4">
    			<a href="{{url('/')}}" class="small-text" :class="weatherClass">Main page</a>
    		</div>
    		<div class="col-sm-4">
    			<a href="{{route('home', ['place'=>'Boulder'])}}" class="small-text" :class="weatherClass">Back to the weather forecast page</a>
    		</div>
    		<div class="col-sm-4">
    			<a href="#" v-if="!celsius" @click="celsius = !celsius" class="small-text" :class="weatherClass">Convert to &deg;C</a>
				<a href="#" v-else @click="celsius = !celsius" class="small-text" :class="weatherClass">Convert to &deg;F</a>
    		</div>
        </div>
        <br>
        <br>
        <br>
        <br>
    	<div class="content">
    		<div class="container">
    			<div class="row">
					<div class="col-sm-4 col-sm-offset-2">
	    				<input type="text" class="subheading btn" id="datepicker1" v-model="date1" :class="weatherClassBtn">
	    			</div>
	    			
	    			<div class="col-sm-4">
	    				<input type="text" class="subheading btn" id="datepicker2" v-model="date2" :class="weatherClassBtn">
	    			</div>
	    		</div>
	    		<div class="row">
					<a :href="url" v-if="d1Selected && d2Selected" @click="show = true" class="subheading btn" :class="weatherClass"><u>Get the weather for this date range</u></a>
					<span v-else  class="subheading btn" :class="weatherClass">Go ahead and enter the 2 dates</span>
					<div v-if="show">
						<span class="subheading" :class="weatherClass">Hang on a bit! It takes time to get the weather!</span>
					</div>
				</div>
			</div>
    		<div class="container">
    			<div class="subheading" :class="weatherClass">
    				When the dates and the weather show up, move the mouse over the cards to change the theme based on the forecast of that day!!
    			</div>
				<div v-for="data in timeMachineData" class="border-double card col-sm-3 @{{data.type}} @{{data.type}}-bg" v-on:mouseover="changeTheme(data.type)">
					<p>@{{data.date}}</p>
					<!-- <span>@{{data.icon}}</span> -->
					<i class="@{{data.icon_type}}"></i>
					<br><br>
	    			<span> @{{data.summary}}</span>
	    			<br><br>
	    			<i v-if="!celsius" class="wi wi-thermometer"> @{{data.temperatureLow}}&deg;F - @{{data.temperatureHigh}}&deg;F</i>
	    			<i v-else class="wi wi-thermometer"> @{{data.temperatureLowCelsius}}&deg;C - @{{data.temperatureHighCelsius}}&deg;C</i>
	    			<br><br>
	    			<i class="wi wi-humidity"> @{{data.humidity}}</i>
	    			<br><br>
	    			<i class="wi wi-strong-wind"> @{{data.windSpeed}} km/hr</i>
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
			celsius: false,
			show: false,
			d1Selected: false,
			d2Selected: false,
			date1: 'Select the start date',
			date2: 'Select the end date',
			dateRange: [],
			url: '',
			timeMachineData: @json($timeMachineData),
			celsius: false,
			weatherClassBackground: 'day-sunny-bg',
			weatherClass: 'day-sunny',
			weatherClassBtn: 'day-sunny-btn'
		},
		watch:
		{
			date1: function()
			{
				this.d1Selected = true;
				if(this.date1 === '')
				{
					window.alert('Please enter your start date');
					this.d1Selected = false;
				}
			},
			date2: function()
			{
				this.d2Selected = true;
				var d1 = new Date(this.date1).getTime()/1000;
				var d2 = new Date(this.date2).getTime()/1000;
				if(this.date2 === '')
				{
					window.alert('Please enter your end date');
					this.d2Selected = false;
				}
				else if(this.date2<this.date1)
				{
					window.alert("Select both dates and the end date can't be before the start date!");
					this.date1 = 'Select the start date';
					this.date2 = 'Select the end date';
					this.show = false;
					this.d1Selected = false;
					this.d2Selected = false;
				}
				else
				{
					this.url =  "http://localhost:8000/time-machine/"+d1+"/"+d2;
				}
			}
		},
		methods:
		{
			changeTheme: function(type)
			{
				this.weatherClassBackground = type+"-bg";
				this.weatherClass = type;
				this.weatherClassBtn = type+"-btn";
			}
		}
	});

	$(function() 
	{
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
	});
</script>
</script>