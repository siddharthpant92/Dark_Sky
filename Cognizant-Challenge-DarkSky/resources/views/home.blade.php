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
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/styles.css') }}" />
    </head>
    <body>
        <div class="flex-center position-ref full-height intro-body">
            <div class="content">
                <div class="intro" style="color: {{$test['color']}}">
                  Hi  {{$test['name']}}
                	<div id="app">
                		<input type="text" v-model="test" @click="testMethod"></input>@{{test}}
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
    		test: ''
    	},
    	methods:
    	{
    		testMethod: function()
    		{
    			console.log("here");
    		}
    	}
    })
</script>