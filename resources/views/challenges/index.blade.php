<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Challenges</h1>

	<ul>
	@foreach ($challenges as $challenge)
		<li>{{$challenge->title}}</li>
	@endforeach
	</ul>
</body>
</html>