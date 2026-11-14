const formulario = document.getElementById("formulario");
const mensagem = document.getElementById("mensagem");
const lista = document.getElementById("lista-recolhas");
const botaoAtualizar = document.getElementById("atualizar");

formulario.addEventListener("submit", async (evento) => {
  evento.preventDefault();
  mensagem.textContent = "A guardar...";

  const dados = new FormData(formulario);

  try {
    const resposta = await fetch("guardar.php", {
      method: "POST",
      body: dados
    });
    const resultado = await resposta.json();

    mensagem.textContent = resultado.mensagem || "Resposta recebida.";
    if (!resposta.ok) return;

    formulario.reset();
    await carregarDados();
  } catch (erro) {
    mensagem.textContent = "Erro de comunicação. Confirme se Apache e MySQL estão ativos.";
  }
});

async function carregarDados() {
  lista.replaceChildren();

  try {
    const resposta = await fetch("listar.php");
    if (!resposta.ok) throw new Error("Falha ao consultar");

    const dados = await resposta.json();

    if (!dados.length) {
      const linha = document.createElement("tr");
      const celula = document.createElement("td");
      celula.colSpan = 5;
      celula.textContent = "Ainda não existem recolhas registadas.";
      linha.appendChild(celula);
      lista.appendChild(linha);
      return;
    }

    dados.forEach((item) => {
      const linha = document.createElement("tr");
      [item.id, item.nome, item.bairro, item.quantidade, item.data_registo]
        .forEach((valor) => {
          const celula = document.createElement("td");
          celula.textContent = valor;
          linha.appendChild(celula);
        });
      lista.appendChild(linha);
    });
  } catch (erro) {
    const linha = document.createElement("tr");
    const celula = document.createElement("td");
    celula.colSpan = 5;
    celula.textContent = "Não foi possível carregar os dados.";
    linha.appendChild(celula);
    lista.appendChild(linha);
  }
}

botaoAtualizar.addEventListener("click", carregarDados);
carregarDados();
