document.querySelectorAll('.titulo-vaga').forEach(function (tituloVaga) {
    tituloVaga.addEventListener('click', function () {
        var descricaoRow = this.parentNode.nextElementSibling;
        if (descricaoRow.style.display === 'none') {
            descricaoRow.style.display = 'table-row';
        } else {
            descricaoRow.style.display = 'none';
        }
    });
});

document.querySelectorAll('.nome-candidato').forEach(function (nomeCandidato) {
    nomeCandidato.addEventListener('click', function () {
        var infoCandidato = this.parentNode.nextElementSibling;
        if (infoCandidato.style.display === 'none') {
            infoCandidato.style.display = 'table-row';
        } else {
            infoCandidato.style.display = 'none';
        }
    });
});

function deletarEmMassaVagas() {
    var idsSelecionados = [];

    var checkboxes = document.querySelectorAll('input[name="vagas_ids[]"]:checked');

    checkboxes.forEach(function (checkbox) {
        idsSelecionados.push(checkbox.value);
    });

    document.getElementById('delete-form').vagas_ids.value = idsSelecionados.join(',');
}

function deletarEmMassaCandidatos() {
    var idsSelecionados = [];

    var checkboxes = document.querySelectorAll('input[name="candidatos_ids[]"]:checked');

    checkboxes.forEach(function (checkbox) {
        idsSelecionados.push(checkbox.value);
    });

    document.getElementById('delete-form').candidatos_ids.value = idsSelecionados.join(',');
}
