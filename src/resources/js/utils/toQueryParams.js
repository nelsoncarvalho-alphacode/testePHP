export function toQueryParams(params) {
    Object.entries(params).forEach(([key, value]) => {
        if (value === undefined || value === null || value === "") {
            delete params[key];
        }
    });

    return "?" + new URLSearchParams(params).toString();
}
