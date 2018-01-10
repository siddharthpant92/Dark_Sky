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
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Styles -->
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}" />
    </head>
    <body>
        <div class="heading">
            Weather Forecast
        </div>
        <div class="subheading">
        	<span>Think the weather changes that quickly and want to <a href="{{url('home')}}"><u>check again?</u></a></span>
        </div>

        <div id="app" class="container" style="padding-top: 50px;">
        	<div style="text-align: center;">
				<a class="btn btn-round blue-background" @click="minutely = !minutely">By the Minute</a>
				<a class="btn btn-round blue-background" @click="hourly = !hourly">By the Hour</a>
				<a class="btn btn-round blue-background" @click="weekly = !weekly">By the Week</a>
			</div>
        	<div class="row" style="text-align: center;">
        		<div class="row border-full">
        			<div class="col-lg-6">
        				<div class="card p4">
        					Overview	
        				</div>
        				
        			</div>
        			<div class="col-lg-6">
        				Summary
        			</div>
        		</div>
			</div>
			<div style="text-align: center;">
				<div class="row border-full" v-show="minutely" id="by-minute">
					Minutely
				</div>
			</div>
			
			<div style="text-align: center;">
				<div class="row border-full" v-show="hourly" id="by-hour">
					hourly
				</div>
			</div>
			
			<div style="text-align: center;">
				<div class="row border-full" v-show="weekly" id="by-week">
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
    		weekly: false
    	}
    })
</script>