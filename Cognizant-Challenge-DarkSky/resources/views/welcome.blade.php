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
					Using the <a href="https://darksky.net/dev/docs">Dark Sky API</a> create a basic app that changes color scheme
					depending on current conditions for a given location.
					<br>
					(Hint: The coordinates for the Boulder office are approximately 40°00&#39;59.2&quot;N 105°17&#39;09.2&quot;W or
					40.016457, -105.285884)
					<br><br>
					Extra Credit:
					Using the <a href="https://darksky.net/dev/docs/time-machine#time-machine-request">time machine feature</a>, cycle the color scheme based on the weather for a date range and interval chosen by the user.
				</div>
				<a class="btn round day-sunny-btn" href="{{route('home', ['place'=>'Boulder'])}}">Let's do this!</a>
				<br><br><br>
				<a href="https://github.com/siddharthpant92/Dark_Sky"> Github repo link</a>
			</div>
		</div>
	</body>
</html>
