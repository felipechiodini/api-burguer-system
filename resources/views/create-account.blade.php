@extends('base')

<body>
    @include('header')

    <style>
        .giohfiowahfiwoaf {
            padding: 2rem;
        }
    </style>

    <section class="giohfiowahfiwoaf">
        <form class="dwoajfwioafhwoai" action="criar-conta" method="POST">
            @csrf
            <h2>Tenha seu próprio aplicativo de delivery</h2>
            <div class="input-group">
                <label for="name">Seu Nome</label>
                <input name="name" id="name" type="text">
            </div>
            <div class="input-group">
                <label for="email">E-mail</label>
                <input name="email" placeholder="Seu principal e-mail" id="email" type="email">
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input name="password" placeholder="Defina sua senha" id="password" type="password">
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
