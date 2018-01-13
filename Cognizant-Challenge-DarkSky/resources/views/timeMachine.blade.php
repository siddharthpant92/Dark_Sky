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
    <body id="app">
    	<div class="content">
    		<div class="row">
    			<div class="col-sm-4 col-sm-offset-4">
	    			<div class="col-sm-6">
	    				<input type="text" id="datepicker1" v-model="date1" placeholder="Select start date">
	    			</div>
	    			
	    			<div class="col-sm-6">
	    				<input type="text" id="datepicker2" v-model="date2" placeholder="Select end date">
	    			</div>
	    			<a @click="getDates">Get dates</a>
	    		</div>
    		</div>
    		<div class="row">
	    		<template v-for="date in dateRange" track-by="$index">
	    			<p>@{{date}}}</p>
	    		</template>
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
			date1: '',
			date2: '',
			dateRange: []
		},
		methods:
		{
			getDates: function()
			{
				//Emptying it so it can calculate from fresh again. Otherwise new dates might get appended
				this.dateRange = [] ;
				var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
				];
				var timestamp1 = new Date(this.date1)
				var timestamp2 = new Date(this.date2)
				
				var date = timestamp1;
				
				while(date <=  timestamp2)
				{
					var year = date.getFullYear();
					var month = monthNames[date.getMonth()];
					var day = date.getDate();
					var formattedDate = day+' '+month+' '+year;
					this.dateRange.push(formattedDate);
					date.setDate(date.getDate() + 1);

				}
			},
		}
	});

	$(function() 
	{
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
	});
</script>
</script>