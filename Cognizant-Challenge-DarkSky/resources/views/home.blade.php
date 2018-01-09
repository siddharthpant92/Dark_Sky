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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Styles -->
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}" />
    </head>
    <body>
        <div id="app">
            <div class="row border-full">
				<div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
				<div class="col-sm-4" style="background-color:lavenderblush;">.col-sm-4</div>
				<div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
			</div>
        </div>
    </body>
</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.27/vue.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    new Vue(
    {
    	el: "#app",
    })
</script>