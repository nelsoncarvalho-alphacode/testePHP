// Função para buscar e exibir as vagas
function listarVagas() {
    var searchInput = document.getElementById('search').value;
    var orderByInput = document.getElementById('order_by').value;

    // Fazer requisição AJAX para buscar as vagas com parâmetros de filtragem
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarVagas.php?search=' + searchInput + '&order_by=' + orderByInput, true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var vagasData = JSON.parse(xhr.responseText);

            // Limpar a tabela
            var tableBody = document.getElementById('vagasBody');
            tableBody.innerHTML = '';

            // Preencher a tabela com os dados das vagas
            vagasData.forEach(function (vaga) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + vaga.id + '</td>' +
                    '<td>' + vaga.titulo + '</td>' +
                    '<td>' + vaga.tipo + '</td>' +
                    '<td>' + vaga.status + '</td>';
                tableBody.appendChild(row);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}

// Evento de envio do formulário
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
    listarVagas(); // Chamar a função para buscar e exibir as vagas
});

// Carregar as vagas ao carregar a página
window.onload = listarVagas;
