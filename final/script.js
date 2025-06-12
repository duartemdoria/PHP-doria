window.onload = function () {
    // setTimeout(() => {
    //     alert("Bem-vindo ao nosso website!");
    // }, 1000);

    carregarRSS();
};

function carregarConteudo(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById("conteudo-principal").innerHTML = data;
        })
        .catch(error => {
            console.error("Erro ao carregar conteúdo:", error);
        });
}

function carregarRSS() {
    fetch('noticias.xml')
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const xml = parser.parseFromString(data, "text/xml");
            const items = xml.querySelectorAll("item");
            const lista = document.getElementById("noticias");

            items.forEach(item => {
                const titulo = item.querySelector("title");
                if (titulo) { // Ensure the title exists
                    const li = document.createElement("li");
                    li.textContent = titulo.textContent;
                    lista.appendChild(li);
                }
            });
        })
        .catch(error => console.error("Erro ao carregar RSS:", error));
}

function abrirImagem(src, descricao) {
    let modal = document.getElementById("modal-imagem");
    if (!modal) {
        modal = document.createElement("div");
        modal.id = "modal-imagem";
        document.body.appendChild(modal);
    }

    modal.innerHTML = `
        <img src="${src}" style="max-width:100%;"><br>
        <p>${descricao}</p>
        <button onclick="document.getElementById('modal-imagem').style.display='none'">Fechar</button>
    `;
    modal.style.display = "block";
}


function initMap() {


    var ponto = new google.maps.LatLng(32.6669, -16.9241); 

    var opcoes = {
        zoom: 14,
        center: ponto,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var m = new google.maps.Map(document.getElementById("mapa"), opcoes);

    var marca = new google.maps.Marker({
        position: ponto,
        map: m,
        title: "Nossa Localização"
    });
    }

   function validarCamposObrigatorios() {
        const nome = document.getElementById("nome");
        const telemovel = document.getElementById("telemovel");
        const email = document.getElementById("email");

        let valido = true;

        if (nome.value.trim() === "") {
            nome.classList.add("erro");
            valido = false;
        } else {
            nome.classList.remove("erro");
        }

        if (telemovel.value.trim() === "") {
            telemovel.classList.add("erro");
            valido = false;
        } else {
            telemovel.classList.remove("erro");
        }

        if (email.value.trim() === "") {
            email.classList.add("erro");
            valido = false;
        } else {
            email.classList.remove("erro");
        }

        if (!valido) {
            alert("Por favor, preencha os campos obrigatórios: Nome, Telemóvel e E-mail.");
        }

        return valido;
}

    function calcularOrcamento() {
      if (!validarCamposObrigatorios()) {
        document.getElementById("orcamento").innerText = "€0.00";
        return;
      }

      const tipoSelecionado = document.getElementById("tipo").value;
      const prazo = parseInt(document.getElementById("prazo").value) || 0;
      const separadoresMarcados = document.querySelectorAll(".separador:checked").length;

      const precosBase = {
        institucional: 500,
        portfolio: 800,
        loja: 1200
      };

      const precoBase = precosBase[tipoSelecionado] || 0;
      const extras = separadoresMarcados * 400;
      const subtotal = precoBase + extras;

      const descontoPercentual = Math.min(prazo * 5, 20);
      const descontoValor = subtotal * (descontoPercentual / 100);
      const totalFinal = subtotal - descontoValor;

      document.getElementById("orcamento").innerText = `€${totalFinal.toFixed(2)}`;
    }



    function realizarLogin(event) {
        event.preventDefault();

        const username = document.getElementById("utilizadores").value.trim();
        const password = document.getElementById("password").value.trim();

        if (username !== "email" && password !== "") {
  
            sessionStorage.setItem("utilizadorLogado", "true");

  
            alert("Login efetuado com sucesso! Bem-vindo, " + utlizadores + "");

         
            window.location.href = "index.php";
        } else {
            alert("Por favor, preencha o nome de utilizador e a senha.");
        }
    }

     document.addEventListener("DOMContentLoaded", function() {
            let utilizadorLogado = sessionStorage.getItem("utilizadorLogado");

            if (utilizadorLogado === "true") {
                document.getElementById("form-marcacao").style.display = "block";
                document.getElementById("login-link").style.display = "none";
                document.getElementById("logout-link").style.display = "inline";
            } else {
                document.getElementById("form-marcacao").style.display = "none";
                document.getElementById("login-link").style.display = "inline";
                document.getElementById("logout-link").style.display = "none";
            }
        });

        function realizarLogout() {
            sessionStorage.removeItem("utilizadorLogado");
            window.location.href = "index.php";
        }

        function submeterMarcacao(event) {
            event.preventDefault();
            const data = document.getElementById("data-reuniao").value;
            const observacoes = document.getElementById("observacoes").value;

            if (!data) {
                alert("Por favor, insira uma data para a reunião.");
                return;
            }

            alert("Marcação submetida com sucesso para: " + data + "\nObservações: " + observacoes);
            document.getElementById("form-marcacao").reset();
        }
