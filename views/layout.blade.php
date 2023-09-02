<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{ asset('vendor/lara-translate/assets/css/style.css') }}">
</head>
<body>
    @include('lara-translate::header')
   @yield('content')
</body>
</html>