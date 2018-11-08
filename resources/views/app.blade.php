<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>tapiwork</title>
    <script type='text/javascript'>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script language="javascript" src="https://webapi.amap.com/maps?v=1.4.8&key=fb7a78fdcc78bd6b20f9feb18b0bf7fa"></script>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>