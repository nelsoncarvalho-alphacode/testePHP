import { formatarMoeda, parseMoeda } from '../utils/currency.js';

document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#itensTable tbody');
    const addItemBtn = document.querySelector('#addItem');

    const atualizarTotais = () => {
        document.querySelectorAll('#itensTable tbody tr').forEach(tr => {
            const qtd = parseFloat(tr.querySelector('input[name*="[quantidade]"]').value) || 0;
            const unitInput = tr.querySelector('.valor-unitario');
            const unit = parseMoeda(unitInput.value);

            unitInput.value = formatarMoeda(unit);
            const total = qtd * unit;
            tr.querySelector('.valor-total').value = formatarMoeda(total);
        });
    };

    const addItem = () => {
        const index = table.querySelectorAll('tr').length;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="itens[${index}][produto_id]" class="form-select" required>
                    <option value="">-- Selecione --</option>
                    ${window.produtosOptions}
                </select>
            </td>
            <td><input type="number" name="itens[${index}][quantidade]" class="form-control" min="1" value="1"></td>
            <td><input type="text" name="itens[${index}][valor_unitario]" class="form-control valor-unitario"></td>
            <td><input type="text" class="form-control valor-total" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
        `;
        table.appendChild(row);
    };

    addItemBtn.addEventListener('click', addItem);

    table.addEventListener('click', e => {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            atualizarTotais();
        }
    });

    table.addEventListener('change', e => {
        if (e.target.matches('select[name^="itens"]')) {
            const preco = parseFloat(e.target.selectedOptions[0].dataset.preco) || 0;
            const row = e.target.closest('tr');
            row.querySelector('.valor-unitario').value = formatarMoeda(preco);
            atualizarTotais();
        }
    });

    table.addEventListener('input', e => {
        if (e.target.matches('input[name*="[quantidade]"], .valor-unitario')) {
            atualizarTotais();
        }
    });

    document.querySelector('form').addEventListener('submit', () => {
        document.querySelectorAll('.valor-unitario').forEach(input => {
            input.value = parseMoeda(input.value);
        });
    });

    atualizarTotais();
});
