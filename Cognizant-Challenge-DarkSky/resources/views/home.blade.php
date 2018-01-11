<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dark Sky</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        
        <!-- Styles -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="/css/weather-icons.css"/>
       <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    </head>
    <body class="{!!$type!!}-bg {!!$type!!}">
<!--         <div class="content">
			<a class="btn round {!!$type!!}-btn">Boulder Office</a>
			<a class="btn round {!!$type!!}-btn">India Office</a>
			<a class="btn round {!!$type!!}-btn">Dubai Office</a>
			<a class="btn round {!!$type!!}-btn">UK Office</a>
		</div> -->
        <div id="app" class="container {!!$type!!}" style="padding-top: 50px;">
        	<div class=" heading row content round">
    			<div>
    				<i class="{!!$icon_type!!}"></i>
    				<h2>{{$forecast->currently->summary}}</h2>
    				<div v-if="!celsius" class="subheading">
    					<h2>
    						@{{farenTemp}}&deg;F
    					</h2>
    					<a @click="celsius = !celsius" class="small-text {!!$type!!}">Convert to &deg;C</a>
    				</div>
    				<div v-else>
    					<h2>@{{celsiusTemp}}&deg;C</h2>
    					<a @click="celsius = !celsius" class="small-text">Convert to &deg;F</a>
    				</div>
    			</div>
    			<div class="content subheading">
    				<div class="col-sm-3">
						<b>Feels like: </b> 
    					<span v-if="!celsius">@{{farenFeelsTemp}}&deg;F</span>
    					<span v-else>@{{celsiusFeelsTemp}}&deg;C</span>	    					
					</div>
					<div class="col-sm-3">
						<b>Time</b> is @{{time}}		
					</div>
					<div class="col-sm-3">
						<b>Humidity</b> is {{$forecast->currently->humidity}}
					</div>
					<div class="col-sm-3">
						<b>Wind Speed</b> is {{$forecast->currently->windSpeed}}km/hr
					</div>
				</div>
			</div>
			
	        <h2 class="subheading">
	        	<span>Think the weather changes that quickly and want to <a href="{{url('home')}}" class="{!!$type!!}"><u>check again?</u></a></span>
	        </h2>
<!-- 			<div class="content">
				<a class="btn round {!!$type!!}-btn" @click="minutely = !minutely">Over the next hour(by the minute)</a>
				<div class="row border-double" v-show="minutely" id="by-minute">
					<div class="col-sm-3">
						<b>After 15min</b>
					</div>
					<div class="col-sm-3">
						<b>After 30min</b>
					</div>
					<div class="col-sm-3">
						<b>After 45min</b>
					</div>
					<div class="col-sm-3">
						<b>After 60min</b>
					</div>
				</div>
			</div> -->
			
			<div class="content">
				<a class="btn round {!!$type!!}-btn" @click="hourly = !hourly">For today and tomorrow</a>
				<div class="row border-double" v-show="hourly" id="by-hour">
					<div class="subheading">
						{{$forecast->hourly->summary}}
					</div>
					<br>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['12']['time']}}</b>
						<br>
						<i class="{!! $hourly['13']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['12']['summary']}}</span>
						<br>
						<span>{{$hourly['12']['temperature']}}&deg;F</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['24']['time']}}</b>
						<br>
						<i class="{!! $hourly['25']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['24']['summary']}}</span>
						<br>
						<span>{{$hourly['24']['temperature']}}&deg;F</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['36']['time']}}</b>
						<br>
						<i class="{!! $hourly['37']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['36']['summary']}}</span>
						<br>
						<span>{{$hourly['36']['temperature']}}&deg;F</span>
					</div>
					<div class="col-sm-3 card-small">
						<b>{{$hourly['48']['time']}}</b>
						<br>
						<i class="{!! $hourly['48']['icon'] !!}"></i>
						<br>
						<span>{{$hourly['48']['summary']}}</span>
						<br>
						<span>{{$hourly['48']['temperature']}}&deg;F</span>
					</div>
				</div>
			</div>
			
			<div class="content">
				<a class="btn round {!!$type!!}-btn" @click="weekly = !weekly">For the next week</a>
				<div class="row border-double" v-show="weekly" id="by-week">
					<div class="col-sm-3 card">
						<b>{{ $daily['1']['time'] }}</b>
						<br>
						<i class="{!! $daily['1']['icon'] !!}"></i>
						<br>
						<span>{{$daily['1']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['1']['temperatureLow']}} to {{$daily['1']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['2']['icon'] !!}"></i>
						<br>
						<span>{{$daily['2']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['2']['temperatureLow']}} to {{$daily['2']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['3']['icon'] !!}"></i>
						<br>
						<span>{{$daily['3']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['3']['temperatureLow']}} to {{$daily['3']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['4']['icon'] !!}"></i>
						<br>
						<span>{{$daily['4']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['4']['temperatureLow']}} to {{$daily['4']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['5']['icon'] !!}"></i>
						<br>
						<span>{{$daily['5']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['5']['temperatureLow']}} to {{$daily['5']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['6']['icon'] !!}"></i>
						<br>
						<span>{{$daily['6']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['6']['temperatureLow']}} to {{$daily['6']['temperatureHigh']}}</i>
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
						<br>
						<i class="{!! $daily['7']['icon'] !!}"></i>
						<br>
						<span>{{$daily['7']['summary']}}</span>
						<br><br>
						<i class="wi wi-thermometer"> {{$daily['7']['temperatureLow']}} to {{$daily['7']['temperatureHigh']}}</i>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<!-- Latest compiled and minified CSS -->
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
    		farenTemp: {{$forecast->currently->temperature}},
    		farenFeelsTemp: Math.round({{$forecast->currently->apparentTemperature}})
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
    			var formattedTime = this.getTime({{$forecast->currently->time}});
    			return formattedTime;
    		}
    	},
    	methods:
    	{
    		getTime: function($time)
    		{
    			// multiplied by 1000 so that the argument is in milliseconds, not seconds.
				var date = new Date($time*1000);
				// Hours part from the timestamp
				var hours = date.getHours();
				// Minutes part from the timestamp
				var minutes = "0" + date.getMinutes();
				// Seconds part from the timestamp
				var seconds = "0" + date.getSeconds();

				// Will display time in 10:30:23 format
				var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

				return formattedTime;

    		}
    	}
    })
</script>