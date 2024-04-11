document.addEventListener('DOMContentLoaded', function () {
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

                // Preencher a tabela com os dados dos candidatos
                candidatosData.forEach(function (candidato) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + candidato.id + '</td>' +
                        '<td>' + candidato.nome + '</td>' +
                        '<td>' + candidato.email + '</td>' +
                        '<td>' + candidato.telefone + '</td>';
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
        listarCandidatos(); // Chamar a função para buscar e exibir os candidatos
    });

    // Carregar os candidatos ao carregar a página
    window.onload = listarCandidatos;
});
