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
                <div class="intro">
                    Hi {{$name}}
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    
</script>