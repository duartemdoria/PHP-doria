<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Website com AJAX e RSS</title>
    <link rel="stylesheet" href="Estilos/style.css">
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOG4kW9VkB9c8f2witVb7_GITjQLB8V6w&callback=initMap"></script>
</head>
<body>
    <header class="navbar">
        <nav>
            <ul>
                <li><a href="#" onclick="carregarConteudo('conteudo/sobre.html')">Início</a></li>
                <li><a href="#" onclick="carregarConteudo('conteudo/portfolio.html')">Portfólio</a></li>
                <li><a href="#" onclick="carregarConteudo('conteudo/orçamento.html')">Orçamento</a></li>
                <li><button onclick="document.getElementById('form-marcacao').style.display = 'block';">Marcar Reunião</button></li>
                <?php if (isset($_SESSION["id_usuario"])): ?>
                    <li><a href="user_area.php">Área do Utilizador</a></li>
                    <?php if ($_SESSION["tipo"] === "administrador"): ?>
                        <li><a href="admin_area.php">Área Administrativa</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <aside id="barra-lateral">
            <h3>Notícias</h3>
            <ul id="noticias"></ul>

            <h3>📍 Localização</h3>
            <div id="mapa" style="width: 200px; height: 175px;">Localização...</div>
        </aside>

        <section id="conteudo-principal">
            <h1>Bem-vindo ao nosso site!</h1>
            <p>Utilize o menu acima para navegar.</p>

            <div id="form-marcacao" style="display: none; margin-top: 20px;">
                <h2>Marcação de Reunião</h2>
                <form onsubmit="submeterMarcacao(event)">
                    <label for="data-reuniao">Data da Reunião:</label>
                    <input type="date" id="data-reuniao" name="data-reuniao" required>
                    <br><br>
                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes"></textarea>
                    <br><br>
                    <button type="submit">Submeter</button>
                </form>
                <p><small>Podes modificar a data da reunião até 72 horas antes.</small></p>
            </div>
        </section>

        <div class="slideshow-container">
            <div class="slide">
                <img src="imagens/img1.jpg" alt="imagem 1">
                <p>Projeto 1: Website institucional desenvolvido com HTML, CSS e JavaScript responsivo.</p>
            </div>
            <div class="slide">
                <img src="imagens/img2.jpg" alt="imagem 2">
                <p>...</p>
            </div>
            <div class="slide">
                <img src="imagens/img3.jpg" alt="imagem 3">
                <p>...</p>
            </div>
            <div class="slide">
                <img src="imagens/img4.jpg" alt="imagem 4">
                <p>...</p>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>