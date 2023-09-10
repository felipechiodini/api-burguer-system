<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bem Vindo</title>
    <style>

        body {
            margin: 0;
        }

        .didapwkdpwa {
            display: flex;

        }

        .dwoajfiowajfwa {
            width: 100%;
            background-color: #fff;
        }

        .box {
            height: 100vh;
            width: 400px;
            box-shadow: 1px 1px 10px #ccc;
            z-index: 2;
            background-color: #ffffff;
            padding: 0 2.5rem;
        }

        .wraper {
            display: flex;
            flex-direction: column
        }

        .submit-button {
            border: none;
            background-color: #006bc8;
            word-spacing: 1px;
            border-radius: 50px;
            color: #fff;
            font-size: 20px;
            padding: 20px
        }

        label {
            color: #2c3357;
            font-size: 17px
        }

        input {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px
        }

        a {
            text-align: center;
            color: #006bc8;
            font-size: 20px;
            text-decoration: none;
            margin: 20px 0;
        }

        a:hover {
            color: #006bc8b9
        }

    </style>
</head>
<body>
    <div class="didapwkdpwa">

        <div class="box">
            <form class="wraper" action="/login" method="POST">
                @csrf
                <h1>Burguer System</h1>
                <h4>Administre seu bar com a gente</h4>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>
                <label for="password">Senha</label>
                <input id="password" name="password" type="password" required>
                <button class="submit-button" type="submit">Acessar</button>
                <a href="">Esqueceu sua senha?</a>
                <label class="wapfowjafwa">
                    Quer vender por delivery com a gente?
                    <a href="">Crie uma conta</a>
                </label>
            </form>
        </div>
        <div class="dwoajfiowajfwa">

        </div>
    </div>
</body>
</html>
