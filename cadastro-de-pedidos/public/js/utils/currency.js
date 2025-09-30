export function formatarMoeda(valor) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
}

export function parseMoeda(valor) {
    if (!valor) return 0;
    return parseFloat(
        valor.replace(/\./g, '') // remove pontos de milhar
             .replace(',', '.') // troca vírgula por ponto
             .replace(/[^\d.-]/g, '') // remove "R$" e outros
    ) || 0;
}
