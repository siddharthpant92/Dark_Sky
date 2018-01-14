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
        <link rel="stylesheet" type="text/css" href="/css/weather-icons.css"/>
       	<link rel="stylesheet" type="text/css" href="/css/styles.css" />	

    </head>
    <body  id="app" class="{!!$type!!}-bg {!!$type!!}">
    	<div class="header">
	    	<div class="row {!!$type!!}-btn">
	    		<div class="col-sm-3">
	    			<a href="{{url('/')}}" class="small-text {!!$type!!}">Main page</a>
	    		</div>
	    		<div class="col-sm-3">
	    			<a v-if="!celsius" href="#" @click="celsius = !celsius" class="small-text {!!$type!!}">Convert to &deg;C</a>
					<a v-else href="#" @click="celsius = !celsius" class="small-text {!!$type!!}">Convert to &deg;F</a>	
	    		</div>
	    		<div class="col-sm-3">
	    			<a v-if="!allOffices" href="#" class="small-text {!!$type!!}" @click="allOffices = !allOffices">Show me the details for a different office</a>
	    			<a v-else href="#" class="small-text {!!$type!!}" @click="allOffices = !allOffices">I don't care about any other office</a>
	    		</div>
	    		<div class="col-sm-3">
	    			<a class="small-text {!!$type!!}" href="#" @click="hourly = !hourly">For today and tomorrow</a>
	    			 | 
	    			<a class="small-text {!!$type!!}" href="#" @click="weekly = !weekly">For the next week</a>
	    		</div>
	        </div>
		</div>
		<br><br><br><br>
        <div class="content" v-if="allOffices">
			<a class="btn round {!!$type!!}-btn" href="{{route('home', ['place'=>'Boulder'])}}">Boulder Office</a>
			<a class="btn round {!!$type!!}-btn" href="{{route('home', ['place'=>'India'])}}">Bangalore Office</a>
			<a class="btn round {!!$type!!}-btn" href="{{route('home', ['place'=>'Australia'])}}">Melbourne Office</a>
			<a class="btn round {!!$type!!}-btn" href="{{route('home', ['place'=>'UK'])}}">London Office</a>
		</div>
        <div class="container {!!$type!!}" style="padding-top: 50px;">
        	<div class="row content round">
    			<div>    				
    				<span class="heading"> @{{time}}</span>
    				<br>
    				<div class="subheading">
	    				<i class="{!!$icon_type!!}"></i>
	    				<span>{{$forecast->currently->summary}}</span>
	    			</div>
    				<div v-if="!celsius">
    					<h2>
    						@{{farenTemp}}&deg;F
    					</h2>
    				</div>
    				<div v-else>
    					<h2>@{{celsiusTemp}}&deg;C</h2>
    				</div>
    			</div>
    			<br><br>
    			<div class="row subheading">
					<div class="col-sm-4">
						<span v-if="!celsius">Feels like: @{{farenFeelsTemp}}&deg;F</span>
						<span v-else>Feels like: @{{celsiusFeelsTemp}}&deg;C</span>	    					
					</div>
					<div class="col-sm-4">
						<span>Humidity: {{$forecast->currently->humidity}}</span>
					</div>
					<div class="col-sm-4">
						<span>Wind Speed: {{$forecast->currently->windSpeed}}km/hr</span>
					</div>
				</div>
			</div>
			<br><br>
	        <h2 class="subheading">
	        	<span>Take me to the <a class="{!!$type!!}" href="{{route('timeMachine')}}"><u>extra credit!</u></a></span>
	        </h2>
	        <br><br>
			<div class="content row" v-show="hourly" id="by-hour">
				<div class="subheading">
					For the next 48 hours: {{$forecast->hourly->summary}}
				</div>	
				<div class="card-small col-sm-3 border-double" v-for="hourlyData in hourlyObject">
					<b>@{{hourlyData.time}}</b>
					<br><br>
					<i class="@{{hourlyData.icon}}"></i>
					<br>
					<span>@{{hourlyData.summary}}</span>
					<br>
					<i class="wi wi-thermometer"></i>
					<span v-if="!celsius">@{{hourlyData.temperature}}&deg;F</span>
					<span v-else>@{{hourlyData.temperatureCelsius}}&deg;C</span>
				</div>
			</div>
			
			
			<div class="content row" v-show="weekly" >
				<div class="subheading">
					Here's the forecast for the next week
				</div>
				<div class="border-double card col-sm-3 col-sm-offset-1" id="by-week" v-for="dailyData in dailyObject">
					<b>@{{dailyData.time}}</b>
					<br><br>
					<i class="@{{dailyData.icon}}"></i>
					<br>
					<span>@{{dailyData.summary}}</span>
					<br><br>
					<i class="wi wi-thermometer"></i>
					<span v-if="!celsius"> @{{dailyData.temperatureLow}}&deg;F to @{{dailyData.temperatureHigh}}&deg;F</span>
					<span v-else> @{{dailyData.temperatureLowCelsius}}&deg;C to @{{dailyData.temperatureHighCelsius}}&deg;C</span>
					<br><br>
					<i class="wi wi-sunrise"></i> @{{dailyData.sunrise}}
					<i class="wi wi-sunset"></i> @{{dailyData.sunset}}
					<br><br>
					<i class="wi wi-humidity"></i> @{{dailyData.humidity}}
					<br><br>
					<i class="wi wi-strong-wind"></i> @{{dailyData.windSpeed}}km/hr
					<br>
				</div>
			</div>
        </div>
    </body>
</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.js"></script>
<script>
    new Vue(
    {
    	el: "#app",
    	data:
    	{
    		minutely: false,
    		hourly: false,
    		weekly: false,
    		celsius: false,
    		allOffices: false,
    		farenTemp: {{$forecast->currently->temperature}},
    		farenFeelsTemp: Math.round({{$forecast->currently->apparentTemperature}}),
    		place: "{{$place}}",
    		dailyObject: @json($daily),
    		hourlyObject: @json($hourly)
    	},
    	computed:
    	{
    		celsiusTemp: function()
    		{
    			return ((this.farenTemp-32)*5/9).toFixed(2);
    		},
    		celsiusFeelsTemp: function()
    		{
    			return (Math.round((this.farenFeelsTemp-32)*5/9));
    		},
    		time: function()
    		{
    			return this.getTime({{$forecast->currently->time}});
    		}
    	},
    	methods:
    	{
    		getTime: function(time)
    		{
    			var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
				];

				//Converting MST to correct times
    			if(this.place==="India")
    			{
    				time += 12*60*60 + 30*60;
    			}
    			else if(this.place==="Australia")
    			{
    				time += 18*60*60;
    			}
    			else if(this.place==="UK")
    			{
    				time += 7*60*60;
    			}

    			// Convert timestamp to milliseconds
				var date = new Date(time*1000);

				// Month
 				var month = monthNames[date.getMonth()];

				// Day
				var day = date.getDate();

				// Hours
				var hours = date.getHours();

				// Minutes
				var minutes = "0" + date.getMinutes();

				// Seconds
				var seconds = "0" + date.getSeconds();

				// Display date time in MM-dd-yyyy h:m:s format
				var formattedTime = day+' '+month+'   '+hours + ':' + minutes.substr(-2);

				return formattedTime;

    		}
    	}
    })
</script>