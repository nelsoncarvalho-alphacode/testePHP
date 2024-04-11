document.addEventListener('DOMContentLoaded', function () {
    // Carregar as vagas disponíveis ao carregar a página
    carregarVagas();

    // Evento de envio do formulário de inscrição
    document.getElementById('formInscricao').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar o comportamento padrão de envio do formulário
        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../app/inscricao.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    alert(response.error);
                } else {
                    alert(response.message);
                    // Limpar o formulário após a inscrição
                    document.getElementById('email').value = '';
                    document.getElementById('vaga_id').selectedIndex = 0;
                    // Atualizar a lista de vagas após a inscrição
                    carregarVagas();
                }
            } else {
                console.error('Erro na requisição AJAX');
            }
        };
        xhr.send(formData);
    });
});

// Função para carregar as vagas disponíveis no menu de seleção
function carregarVagas() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/listarVagas.php', true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            var vagasData = JSON.parse(xhr.responseText);

            // Limpar as opções existentes no menu de seleção
            var selectVaga = document.getElementById('vaga_id');
            selectVaga.innerHTML = '';

            // Adicionar uma opção padrão
            var optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Selecione uma vaga';
            selectVaga.appendChild(optionDefault);

            // Preencher o menu de seleção com as vagas disponíveis
            vagasData.forEach(function (vaga) {
                var option = document.createElement('option');
                option.value = vaga.id;
                option.text = vaga.titulo;
                selectVaga.appendChild(option);
            });
        } else {
            console.error('Erro na requisição AJAX');
        }
    };
    xhr.send();
}
