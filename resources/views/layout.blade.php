<!DOCTYPE html>
<html>
<head lang="pt">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="software,cardápio online,sistma,delivery" />
    <meta name="description" content="" />
    <meta name="author" content="Burguer System" />
    <link rel="shortcut icon" href="{{ asset('images/icon.svg') }}" type="image/x-icon">
    <title>Burguer System - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
    @include('header')
    @yield('content')
</body>
</html>
