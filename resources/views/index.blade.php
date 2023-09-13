<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="sistema,bares,restaurantes" />
    <meta name="description" content="Sistema para bares e restaurantes" />
    <meta name="author" content="Felipe Chiodini Bona" />
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&family=Nunito+Sans:opsz@6..12&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <title>Burguer System</title>

    <style>
        .email-input {
            width: 100%;
            border: none;
            padding: 15px 25px;
            border-radius: 25px;
            margin-bottom: 15px;
        }

        .email-input:focus {
            outline: none
        }

        .button-create {
            width: 100%;
            border: none;
            border-radius: 25px;
            padding: 15px;
            background-color: #ea1d2c;
            color: #fff;
        }

        .img {
            display: block;
            margin: auto;
            height: 200px;
        }

        .text-primary {
            color: #ea1d2c;
        }

    </style>
</head>

<body>
    <div class="hero_area">
        <div class="hero_bg_box">
            {{-- <img src="images/hero-bg.jpg" alt=""> --}}
        </div>
        <header class="header_section">
            <div class="header_bottom">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container ">
                        <h3 class="navbar-brand" href="index.html">Burguer System</h3>

                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class=""> </span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/planos-e-precos">Preços</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/solucoes">Soluções</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contato</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">Acessar</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <section style="margin: 10px; color: #fff">
            <h3>Aplicativo para Delivery</h3>
            <p>Plano gratuito para quem está começando</p>
            <button class="button-create">Criar Agora</button>
        </section>
    </div>

    <section class="container my-4">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="form_container">
                    <div class="heading_container heading_center">
                        <h2>Entre em Contato</h2>
                    </div>
                    <form action="/create" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input name="name" type="text" class="form-control" placeholder="Nome" />
                            @if ($errors->has('name'))
                            <small class="error">{{ $errors->first('name') }}</small>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input name="cellphone" type="text" class="form-control" placeholder="Celular" />
                            @if ($errors->has('cellphone'))
                            <small class="error">{{ $errors->first('cellphone') }}</small>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input name="email" type="email" class="form-control" placeholder="Email" />
                            @if ($errors->has('email'))
                            <small class="error">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input name="message" type="text" class="message-box form-control" placeholder="Mensagem" />
                            @if ($errors->has('message'))
                            <small class="error">{{ $errors->first('message') }}</small>
                            @endif
                        </div>
                        <button class="button-create mb-3 bg-primary">ENVIAR</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="info_section">
        <div class="container">
            <div class="info_top">
                <div class="row">
                    <div class="col-md-3">
                        <a class="navbar-brand" href="/">
                            Burguer System
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="social_box">
                            <a target="_blanck" href="https://www.instagram.com/burguersystem/">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer_section">
        <div class="container">
            <p>
                &copy; <span id="displayYear"></span> Todos os Direitos Resevados por Burguer System
            </p>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
        integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->
</body>

</html>
