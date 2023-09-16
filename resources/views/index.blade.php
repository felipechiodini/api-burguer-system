@extends('layout')

@section('title', 'Aplicativo de Delivery')

@section('content')
<style>
    .main-section {
        display: flex;
        flex-direction: column;
        justify-items: center;
        justify-content: center;
        background-color: #ea8b25;
        padding: 1.5rem;
    }

    .main-section h1 {
        margin: 0;
        font-size: 2.5rem;
    }

    .main-section img {
        height: 450px;
        width: 100%;
        object-fit: contain;
    }

    .main-section a {
        border: none;
        text-decoration: none;
        background-color: #ea1d2c;
        border-radius: 5px;
        padding: 10px;
        color: #ffffff;
        text-align: center;
        font-size: 1.4rem;
    }

</style>

<section class="main-section">
    <h1>Aplicativo de delivery para o seu negócio</h1>
    <img src="{{ asset('images/cellphone.png') }}" alt="cellphone">
    <a href="/criar-conta">Criar Conta Grátis</a>
</section>
@endsection
