<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <title>{{ \PrettyRoutes\Facades\Trans::get('title') }} | {{ config('app.name') }}</title>

    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    @include('pretty-routes::favicon')
    @include('pretty-routes::styles')
</head>
<body>

<div id="app">
    @include('pretty-routes::vue')
</div>

@include('pretty-routes::scripts')

</body>
</html>
