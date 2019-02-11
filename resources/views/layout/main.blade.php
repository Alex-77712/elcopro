<!DOCTYPE html>
<html>
<head>
	<title>Elcopro Tz</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
	<div id="app">
		@yield('content')
	</div>
	<script type="text/javascript" src="{{ asset('js/app.js') }}" defer=""></script>
</body>
</html>