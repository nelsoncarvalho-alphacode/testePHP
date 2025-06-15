export function toFormattedDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString("pt-BR", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
    });
}
