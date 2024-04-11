// Função para buscar e exibir os candidatos
function listarCandidatos() {
    var searchInput = document.getElementById('search').value;
    var orderByInput = document.getElementById('order_by').value;

    // Fazer requisição AJAX para buscar os candidatos com parâmetros de filtragem
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarCandidatos.php?search=' + searchInput + '&order_by=' + orderByInput, true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var candidatosData = JSON.parse(xhr.responseText);

            // Limpar a tabela
            var tableBody = document.getElementById('candidatosBody');
            tableBody.innerHTML = '';

            // Preencher a tabela com os dados dos candidatos e botões de exclusão
            candidatosData.forEach(function (candidato) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + candidato.id + '</td>' +
                    '<td>' + candidato.nome + '</td>' +
                    '<td>' + candidato.email + '</td>' +
                    '<td>' + candidato.telefone + '</td>' +
                    '<td><button onclick="excluirCandidato(' + candidato.id + ')">Excluir</button></td>';
                tableBody.appendChild(row);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

// Função para confirmar a exclusão do candidato
function excluirCandidato(id) {
    var confirmacao = confirm('Tem certeza que deseja excluir o candidato com ID ' + id + '?');
    if (confirmacao) {
        // Fazer requisição AJAX para excluir o candidato
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../app/excluirCandidatos.php?id=' + id, true); // Corrigido para excluirCandidato.php
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Candidato excluído com sucesso!');
                listarCandidatos(); // Atualizar a lista após a exclusão
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }
}

// Evento de envio do formulário
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
    listarCandidatos(); // Chamar a função para buscar e exibir os candidatos
});

// Carregar os candidatos ao carregar a página
window.onload = listarCandidatos;
