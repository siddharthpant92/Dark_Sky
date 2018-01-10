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
        <div class="heading">
            Weather Forecast
        </div>
        <div class="subheading">
        	<span>Think the weather changes that quickly and want to <a href="{{url('home')}}"><u>check again?</u></a></span>
        </div>

        <div id="app" class="container {!!$type!!}" style="padding-top: 50px;">
        	<div class="content">
				<a class="btn round blue-background" @click="minutely = !minutely">By the Minute</a>
				<a class="btn round blue-background" @click="hourly = !hourly">By the Hour</a>
				<a class="btn round blue-background" @click="weekly = !weekly">By the Week</a>
			</div>
        	<div class="row content round">
    			<div class="heading" style="padding-top: 10px;">
    				<h2 class="subheading">{{$forecast->currently->summary}}
    					<i class="{!!$icon_type!!}"></i>
    				</h2>
    				<div v-if="!celsius">
    					<h2>
    						@{{farenTemp}}&deg;F
    					</h2>
    					<a @click="celsius = !celsius" class="small-text">Convert to &deg;C</a>
    				</div>
    				<div v-else>
    					<h2>@{{celsiusTemp}}&deg;C</h2>
    					<a @click="celsius = !celsius" class="small-text">Convert to &deg;F</a>
    				</div>
    			</div>
    			<div class="content">
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
						<b>Wind Speed is</b> is {{$forecast->currently->windSpeed}}km/hr
					</div>
				</div>
			</div>

			<div class="content">
				<div class="row border-double" v-show="minutely" id="by-minute">
					Minutely
				</div>
			</div>
			
			<div class="content">
				<div class="row border-double" v-show="hourly" id="by-hour">
					Hourly
				</div>
			</div>
			
			<div class="content">
				<div class="row border-double" v-show="weekly" id="by-week">
					Weekly
				</div>
			</div>
			
        </div>
    </body>
</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.js"></script>
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
    			// multiplied by 1000 so that the argument is in milliseconds, not seconds.
				var date = new Date({{$forecast->currently->time}}*1000);
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