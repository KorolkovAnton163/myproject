<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/favicon.png" type="image/png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="description" content="This my site">
    <title>myproject</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}?v={{ config('app.version') }}"/>
    <script type="text/javascript">
        window.Laravel = {!!  json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
    <script>
        window.user = {!! json_encode($user) !!}
    </script>
</head>
<body>
<div id="app">
    <message-box></message-box>
    <top-nav-menu></top-nav-menu>
    <app-header></app-header>
    <router-view></router-view>
    <app-footer></app-footer>
    <div style="display: none;"><?php include public_path('svg/sprites.svg'); ?></div>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}?v={{ config('app.version') }}"></script>
</body>
</html>
