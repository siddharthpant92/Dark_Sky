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
    	<div class="content">
    		<div class="container">
				<div class="col-sm-4 col-sm-offset-2">
    				<input type="text" class="subheading btn" id="datepicker1" v-model="date1" placeholder="Select start date" :class="weatherClassBtn">
    			</div>
    			
    			<div class="col-sm-4">
    				<input type="text" class="subheading btn" id="datepicker2" v-model="date2" placeholder="Select end date" :class="weatherClassBtn">
    			</div>
				<a :href="url" @click="show = true" class="subheading btn" :class="weatherClassBtn">Get dates</a>
				<div v-if="!d1Selected" class="small-text" :class="weatherClassBtn">
					Start by selecting the start date!
				</div>
				<div v-if="!d2Selected" class="small-text" :class="weatherClassBtn">
					Don't forget to select the end date!
				</div>
				<div v-if="show" class="small-text" :class="weatherClassBtn">
					Hang on a bit! It takes time to predict the weather!
				</div>
			</div>
    		<div class="container col-sm-offset-1">
				<div v-for="data in timeMachineData" class="border-double card col-sm-3 @{{data.type}} @{{data.type}}-bg" v-on:mouseover="test(data.type)">
					<p>@{{data.date}}</p>
					<!-- <span>@{{data.icon}}</span> -->
					<i class="@{{data.icon_type}}"></i>
					<br><br>
	    			<span> @{{data.summary}}</span>
	    			<br><br>
	    			<i class="wi wi-thermometer"> @{{data.temperatureLow}}&deg;F - @{{data.temperatureHigh}}&deg;F</i>
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
			show: false,
			d1Selected: false,
			d2Selected: false,
			date1: '',
			date2: '',
			dateRange: [],
			url: '',
			timeMachineData: @json($timeMachineData),
			celsius: false,
			weatherClassBackground: '',
			weatherClassBtn: ''
		},
		watch:
		{
			date1: function()
			{
				this.d1Selected = true;
			},
			date2: function()
			{
				this.d2Selected = true;
				var d1 = new Date(this.date1).getTime()/1000;
				var d2 = new Date(this.date2).getTime()/1000;
				if(!this.d1Selected || !this.d2Selected || this.date2<this.date1)
				{
					this.date1 = null;
					this.date2 = null;
					window.alert("Select both dates and the end date can't be before the start date!");
				}
				else
				{
					this.url =  "http://localhost:8000/time-machine/"+d1+"/"+d2;
				}
			}
		},
		methods:
		{
			test: function(type)
			{
				this.weatherClassBackground = type+"-bg";
				this.weatherClassBtn = type+"-btn"
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