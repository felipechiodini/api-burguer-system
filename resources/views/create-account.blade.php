<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burguer System - Criar minha conta grátis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro&family=Nunito+Sans:opsz@6..12&family=Work+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background-color: #ffffff;
            color: #ea1d2c;
            font-family: 'Maven Pro', sans-serif;
            font-family: 'Nunito Sans', sans-serif;
            font-family: 'Work Sans', sans-serif;
        }

        header {
            background-color: #ea1d2c;
            padding: 1.3rem .5rem;
        }

        header h1 {
            color: #fff;
            font-size: 1.8rem;
            margin: 0;
        }

        .first-section {
            padding: 2rem;
        }

        .dwoajfwioafhwoai {
            display: flex;
            flex-direction: column
        }

        .dwoajfwioafhwoai .input-group {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-bottom: 10px;
        }

        .dwoajfwioafhwoai label {
            color: #424242;
            margin-bottom: 3px;
        }


        .dwoajfwioafhwoai .title {
            font-size: 2rem;
        }

        input {
            border: 1px solid #000;
            padding: 10px;
        }

        button {
            border: none;
            background-color: #ea1d2c;
            border-radius: 2rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            padding: 20px;
        }

    </style>
</head>
<body>
    <header>
        <h1>Burguer System</h1>
    </header>
    <section class="first-section">
        <form class="dwoajfwioafhwoai" action="criar-conta" method="POST">
            @csrf
            <h2 class="title">Tenha seu próprio aplicativo de delivery</h2>
            <div class="input-group">
                <label for="name">Nome do seu Bar / Resturante</label>
                <input name="name" id="name" type="text">
            </div>
            <div class="input-group">
                <label for="name">E-mail</label>
                <input name="name" placeholder="Seu principal e-mail" id="email" type="email">
            </div>
            <div class="input-group">
                <label for="name">Senha</label>
                <input name="name" placeholder="Defina sua senha" id="name" type="text">
            </div>
            <div class="mb-2" style="margin-bottom: 20px;">
                <input type="checkbox" name="terms" id="terms">
                <label for="terms">Aceito os Termos e Confições e a Política de Privacidade da Burguer System</label>
            </div>
            <button>Criar minha conta</button>
            <h4>Já tem uma conta? <a href="/login">Acesse</a>.</h4>
        </form>
    </section>
</body>
</html>
