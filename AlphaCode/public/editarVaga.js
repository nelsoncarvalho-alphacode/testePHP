document.addEventListener('DOMContentLoaded', function () {
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

                // Preencher a tabela com os dados das vagas e botão de edição
                vagasData.forEach(function (vaga) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + vaga.id + '</td>' +
                        '<td>' + vaga.titulo + '</td>' +
                        '<td>' + vaga.tipo + '</td>' +
                        '<td>' + vaga.status + '</td>' +
                        '<td><button onclick="preencherCamposEdicao(' + vaga.id + ', \'' + vaga.titulo + '\', \'' + vaga.tipo + '\', \'' + vaga.status + '\')">Editar</button></td>';
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }

    // Evento de envio do formulário de edição
    document.getElementById('formEditarVaga').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/editarVaga.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Vaga editada com sucesso!');
                listarVagas(); // Atualizar a lista após a edição
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });

    // Chamar a função para listar as vagas ao carregar a página
    listarVagas();
});

// Função para preencher os campos de edição com os dados da vaga selecionada
function preencherCamposEdicao(id, titulo, tipo, status) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_titulo').value = titulo;
    document.getElementById('edit_tipo').value = tipo;
    document.getElementById('edit_status').value = status;
}
