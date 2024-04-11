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

                // Preencher a tabela com os dados dos candidatos e botão de edição
                candidatosData.forEach(function (candidato) {
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + candidato.id + '</td>' +
                        '<td>' + candidato.nome + '</td>' +
                        '<td>' + candidato.email + '</td>' +
                        '<td>' + candidato.telefone + '</td>' +
                        '<td><button onclick="preencherCamposEdicao(' + candidato.id + ', \'' + candidato.nome + '\', \'' + candidato.email + '\', \'' + candidato.telefone + '\')">Editar</button></td>';
                    tableBody.appendChild(row);
                });
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send();
    }

    // Evento de envio do formulário de edição
    document.getElementById('formEditarCandidato').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/editarCandidatos.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert('Candidato editado com sucesso!');
                listarCandidatos(); // Atualizar a lista após a edição
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });

    // Chamar a função para listar os candidatos ao carregar a página
    listarCandidatos();
});

// Função para preencher os campos de edição com os dados do candidato selecionado
function preencherCamposEdicao(id, nome, email, telefone) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_telefone').value = telefone;
}
