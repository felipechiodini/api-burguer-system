<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="sistema,bares,restaurantes" />
    <meta name="description" content="Sistema para bares e restaurantes" />
    <meta name="author" content="Felipe Chiodini Bona" />
    <link rel="shortcut icon" href="{{ asset('images/icon.svg') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <title>Burguer System - @yield('title')</title>
    <style>

        body {
            margin: 0;
            font-family: 'Maven Pro', sans-serif;
            background-color: #fff;
            color: #363636;
        }

        input {
            width: 100%;
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    @yield('content')
</body>
</html>
