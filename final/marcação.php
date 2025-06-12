<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}
?>
 
 <!DOCTYPE html>
 <html lang="pt">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcação</title>
 </head>
 <body>
    
<button onclick="document.getElementById('form-marcacao').style.display = 'block';">
    Marcar Reunião
</button>
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
            <script>
                    function submeterMarcacao(event) {
                    event.preventDefault();

                    const data = document.getElementById('data-reuniao').value;
                    const observacoes = document.getElementById('observacoes').value;

                    fetch('processar_marcacao.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `data_reuniao=${encodeURIComponent(data)}&observacoes=${encodeURIComponent(observacoes)}`
                    })
                    .then(response => response.text())
                    .then(result => {
                        alert(result);
                        document.getElementById('form-marcacao').reset();
                        document.getElementById('form-marcacao').style.display = 'none';
                    })
                    .catch(error => {
                        alert('Erro ao enviar a marcação.');
                        console.error(error);
                    });
                }
                </script>

                </body>

</html>