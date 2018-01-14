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
       <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    </head>
    <body>
        <div class="intro-body">
            <div class="content">
                <div class="intro">
                    Using the Dark Sky API (https://darksky.net/dev/), create a basic app that changes color scheme
                    depending on current conditions for a given location.
                    <br>
                    (Hint: The coordinates for our office are approximately 40°00&#39;59.2&quot;N 105°17&#39;09.2&quot;W or
                    40.016457, -105.285884)
                    <br><br>
                    Extra Credit:
                    Using https://darksky.net/dev/docs/time-machine, cycle the color scheme based on the weather for a date range and interval chosen by the user.
                </div>
                <a class="btn round day-sunny-btn" href="{{route('home', ['place'=>'Boulder'])}}">Let's do this!</a>
            </div>
        </div>
    </body>
</html>
