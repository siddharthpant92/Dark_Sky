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
    	<div class="row header {!!$type!!}-btn">
    		<div class="col-sm-3">
    			<a href="{{url('/')}}" class="small-text {!!$type!!}">Main page</a>
    		</div>
    		<div class="col-sm-3">
    			<a v-if="!celsius" @click="celsius = !celsius" class="small-text {!!$type!!}">Convert to &deg;C</a>
				<a v-else @click="celsius = !celsius" class="small-text {!!$type!!}">Convert to &deg;F</a>	
    		</div>
    		<div class="col-sm-3">
    			<a v-if="!allOffices" class="small-text {!!$type!!}" @click="allOffices = !allOffices">Show me the details for a different office</a>
    			<a v-else class="small-text {!!$type!!}" @click="allOffices = !allOffices">I don't care about any other office</a>
    		</div>
    		<div class="col-sm-3">
    			<a class="small-text {!!$type!!}" @click="hourly = !hourly">For today and tomorrow</a>
    			 | 
    			<a class="small-text {!!$type!!}" @click="weekly = !weekly">For the next week</a>
    		</div>
        </div>
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
    			<div class="content">
    				<div class="col-sm-4">
						<b>Feels like: </b> 
    					<span v-if="!celsius">@{{farenFeelsTemp}}&deg;F</span>
    					<span v-else>@{{celsiusFeelsTemp}}&deg;C</span>	    					
					</div>
					<div class="col-sm-4">
						<b>Humidity</b> is {{$forecast->currently->humidity}}
					</div>
					<div class="col-sm-4">
						<b>Wind Speed</b> is {{$forecast->currently->windSpeed}}km/hr
					</div>
				</div>
			</div>
			<br><br>
	        <h2 class="subheading">
	        	<span>Take me to the <a class="{!!$type!!}" href="{{route('timeMachine')}}"><u>extra credit!</u></a></span>
	        </h2>

			<div class="content">				
				<div class="row border-double" v-show="hourly" id="by-hour">
					<div class="subheading">
						{{$forecast->hourly->summary}}
					</div>
					<br>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['12']['time']}}</b>
						<br><br>
						<i class="{!! $hourly['13']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['12']['summary']}}</span>
						<br>
						<span v-if="!celsius">{{$hourly['12']['temperature']}}&deg;F</span>
						<span v-else>{{$hourly['12']['temperatureCelsius']}}&deg;C</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['24']['time']}}</b>
						<br><br>
						<i class="{!! $hourly['25']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['24']['summary']}}</span>
						<br>
						<span v-if="!celsius">{{$hourly['24']['temperature']}}&deg;F</span>
						<span v-else>{{$hourly['24']['temperatureCelsius']}}&deg;C</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['36']['time']}}</b>
						<br><br>
						<i class="{!! $hourly['37']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['36']['summary']}}</span>
						<br>
						<span v-if="!celsius">{{$hourly['36']['temperature']}}&deg;F</span>
						<span v-else>{{$hourly['36']['temperatureCelsius']}}&deg;C</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['48']['time']}}</b>
						<br><br>
						<i class="{!! $hourly['48']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['48']['summary']}}</span>
						<br>
						<span v-if="!celsius">{{$hourly['48']['temperature']}}&deg;F</span>
						<span v-else>{{$hourly['48']['temperatureCelsius']}}&deg;C</span>
					</div>
				</div>
			</div>
			
			<div class="content">
				
				<div class="row border-double" v-show="weekly" id="by-week">
					<div class="col-sm-3 card">
						<b>{{ $daily['1']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['1']['icon'] !!}"></i>
						<br>
						<span>{{$daily['1']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['1']['temperatureLow']}}&deg;F to {{$daily['1']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['1']['temperatureLowCelsius']}}&deg;C to {{$daily['1']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['1']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['1']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['1']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['1']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['2']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['2']['icon'] !!}"></i>
						<br>
						<span>{{$daily['2']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['2']['temperatureLow']}}&deg;F to {{$daily['2']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['2']['temperatureLowCelsius']}}&deg;C to {{$daily['2']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['2']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['2']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['2']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['2']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['3']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['3']['icon'] !!}"></i>
						<br>
						<span>{{$daily['3']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['3']['temperatureLow']}}&deg;F to {{$daily['3']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['3']['temperatureLowCelsius']}}&deg;C to {{$daily['3']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['3']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['3']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['3']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['3']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['4']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['4']['icon'] !!}"></i>
						<br>
						<span>{{$daily['4']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['4']['temperatureLow']}}&deg;F to {{$daily['4']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['4']['temperatureLowCelsius']}}&deg;C to {{$daily['4']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['4']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['4']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['4']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['4']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['5']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['5']['icon'] !!}"></i>
						<br>
						<span>{{$daily['5']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['5']['temperatureLow']}}&deg;F to {{$daily['5']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['5']['temperatureLowCelsius']}}&deg;C to {{$daily['5']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['5']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['5']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['5']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['5']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['6']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['6']['icon'] !!}"></i>
						<br>
						<span>{{$daily['6']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['6']['temperatureLow']}}&deg;F to {{$daily['6']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['6']['temperatureLowCelsius']}}&deg;C to {{$daily['6']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['6']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['6']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['6']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['6']['windSpeed']}}km/hr</i>
						<br>
					</div>
					<div class="col-sm-3 card">
						<b>{{ $daily['7']['time'] }}</b>
						<br><br>
						<i class="{!! $daily['7']['icon'] !!}"></i>
						<br>
						<span>{{$daily['7']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer">
							<span v-if="!celsius"> {{$daily['7']['temperatureLow']}}&deg;F to {{$daily['7']['temperatureHigh']}}&deg;F</span>
							<span v-else> {{$daily['7']['temperatureLowCelsius']}}&deg;C to {{$daily['7']['temperatureHighCelsius']}}&deg;C</span>
						</i>
						<br><br>
						<i class="wi wi-sunrise"> {{$daily['7']['sunrise']}}</i>						
						<i class="wi wi-sunset"> {{$daily['7']['sunset']}}</i>
						<br><br>
						<i class="wi wi-humidity"> {{$daily['7']['humidity']}}</i>
						<br><br>
						<i class="wi wi-strong-wind"> {{$daily['7']['windSpeed']}}km/hr</i>
						<br>
					</div>
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
    		place: "{{$place}}"
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