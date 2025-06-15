export function toStringDate(dateStr) {
    const date = new Date(dateStr);

    const leftZeroMonth = date.getMonth() < 9 ? "0" : "";
    const leftZeroDay = date.getDate() < 10 ? "0" : "";

    return `${date.getFullYear()}-${leftZeroMonth}${
        date.getMonth() + 1
    }-${leftZeroDay}${date.getDate()}`;
}
