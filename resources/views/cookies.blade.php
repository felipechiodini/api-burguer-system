
<style>
    .cookies {
        display: none;
        position: absolute;
        bottom: 0;
        flex-direction: column;
        padding: 10px;
        background-color: #363636;
        color: #fff;
        transition: .1 ease;
    }

    .cookies p {
        margin: 0;
    }

    .cookies span {
        float: right;
    }

    .cookies button {
        padding: 10px;
        border: none;
        color: #363636;
        font-size: 1rem;
        background-color: #fff;
        margin-bottom: 5px;
    }

</style>

<section class="cookies">
    <span id="close-cookies" onclick="close()">X</span>
    <p>Usamos cookies no nosso site para ver como você interage com ele. Ao aceitar, você concorda com o uso de cookies.</p>
    <button>Aceitar</button>
    <button>Configurações</button>
</section>

<script>
    function close() {
        document.getElementsByClassName('cookies').style.display = 'none'
    }
</script>
