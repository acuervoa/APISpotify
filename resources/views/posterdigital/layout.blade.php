<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Spotify app - by Andrés Cuervo</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/posterdigital.css">

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
    <body class="posterdigital">
        <div class="container-fluid">

            @yield('content')

        </div>
    </body>

    <!-- Vue -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</html>
