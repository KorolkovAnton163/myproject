<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>myproject</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="description" content="This my site">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
    <script type="text/javascript">
        window.Laravel = {!!  json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
    <script>
        window.user = {!! json_encode($user) !!}
    </script>
</head>
<body>
<div id="app">
    <top-nav-menu></top-nav-menu>
    <app-header></app-header>
    <router-view></router-view>
    <app-footer></app-footer>
    <div style="display: none;"><?php include public_path('svg/sprites.svg'); ?></div>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
