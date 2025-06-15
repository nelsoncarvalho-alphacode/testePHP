import { toBRL } from "./utils/toBRL.js";
import { toFormattedDate } from "./utils/toFormattedDate.js";
import { toStringDate } from "./utils/toStringDate.js";
import { toQueryParams } from "./utils/toQueryParams.js";

import { rootApiUrl, endpointsMap } from "./variables.js";

const { pathname } = location;
let endpoint = endpointsMap.get(pathname.split("/")[1]);

const orderStatusLabels = {
    pending: "Em aberto",
    payed: "Pago",
    canceled: "Cancelado",
};

const queryParams = {
    offset: 0,
    limit: 20,
    sortByColumn: "id",
    sortByType: "ASC",
    filterByValue: "",
    filterByDate: "",
    filterByStatus: "",
};

let selectedItems = [];

let selectedId = 0;

const closeModalElement = document.getElementById("modal-close-btn");
const triggerModalElement = document.getElementById("items-form-trigger");
let form = document.getElementById("items-form");

window.onload = () => {
    getItems();

    handleItemsPerPageChange();
    handleFilter();

    document
        .getElementById("remove-selected-btn")
        .addEventListener("click", (e) => {
            const response = confirm(
                "Deseja confirmar a exclusão dos itens selecionados?"
            );

            if (response) {
                fetch(rootApiUrl + "bulk/" + endpoint, {
                    method: "DELETE",
                    body: JSON.stringify({
                        ids: selectedItems.map((id) => +id),
                    }),
                    headers: {
                        "Content-Type": "application/json",
                    },
                }).then(() => {
                    alert("Itens excluídos com sucesso!");

                    selectedItems = [];
                    document.getElementById(
                        "remove-selected-btn"
                    ).disabled = true;

                    getItems();
                });
            }
        });

    triggerModalElement.addEventListener("click", () => {
        handleCleanForm();

        const titleElement = document.getElementById("form-title");
        titleElement.textContent = "Cadastrar ";

        switch (endpoint) {
            case "clients": {
                titleElement.textContent = titleElement.textContent + "cliente";

                break;
            }
            case "products": {
                titleElement.textContent = titleElement.textContent + "produto";

                break;
            }
            case "orders": {
                titleElement.textContent = titleElement.textContent + "pedido";

                break;
            }
        }

        form.addEventListener("submit", (e) => {
            e.preventDefault();
        });
        handleSetSubmitEvent("POST");
    });

    if (endpoint === "orders") {
        const clientSelectElement = document.getElementById("client_id");
        const productSelectElement = document.getElementById("product_id");

        fetch(rootApiUrl + "clients/all").then(async (response) => {
            const data = await response.json();
            data.forEach((item) => {
                clientSelectElement.insertAdjacentHTML(
                    "afterbegin",
                    `<option value="${item.id}">${
                        item.name + " " + item.surname
                    }</option>`
                );
            });
        });
        fetch(rootApiUrl + "products/all").then(async (response) => {
            const data = await response.json();
            data.forEach((item) => {
                productSelectElement.insertAdjacentHTML(
                    "afterbegin",
                    `<option value="${item.id}">${item.name}</option>`
                );
            });
        });
    }

    if (endpoint === "clients" || endpoint === "products") {
        const id = pathname.split("/")[2];

        if (id) {
            fetch(rootApiUrl + endpoint + "/" + id).then(async (response) => {
                const data = await response.json();

                if (!!data) {
                    const fakeUpdateBtn = document.createElement("button");
                    fakeUpdateBtn.setAttribute("data-bs-target", "#form-modal");
                    fakeUpdateBtn.setAttribute("data-bs-toggle", "modal");
                    fakeUpdateBtn.style.display = "none";
                    document.body.append(fakeUpdateBtn);

                    fakeUpdateBtn.click();

                    selectedId = data.id;
                    handleSetUpdateForm(data);
                }
            });
        }
    }
};

function getItems() {
    const { limit, offset } = queryParams;

    const queryParamsUrl = toQueryParams(queryParams);

    fetch(rootApiUrl + endpoint + queryParamsUrl)
        .then(async (response) => {
            const data = await response.json();

            const { total, items } = data;

            if (total === 0) return alert("Nenhum item encontrado!");

            createPagination(total, Math.floor(offset / limit));

            createTableRows(items);
        })
        .catch((e) => alert("Ops... Algo de errado ocorreu!"));
}

function createTableRows(items) {
    const theadElement = document
        .getElementById("table")
        .getElementsByTagName("thead")[0];
    const tbodyElement = document
        .getElementById("table")
        .getElementsByTagName("tbody")[0];

    theadElement.innerHTML = "";
    tbodyElement.innerHTML = "";

    if (endpoint === "clients") {
        theadElement.append(
            createSortableHeader([
                { text: "", sortable: false },
                { text: "Nome", column: "name" },
                { text: "Sobrenome", column: "surname" },
                { text: "Email", column: "email" },
                { text: "CPF", column: "cpf" },
            ])
        );

        items.forEach((item) => {
            const row = tbodyElement.insertRow();
            row.innerHTML = `
                        <td><input class="form-check-input" type="checkbox" value=${
                            item.id
                        }></td>
                        <td>${item.name}</td>
                        <td>${item.surname}</td>
                        <td>${item.email ?? "Não cadastrado"}</td>
                        <td>${item.cpf.replace(
                            /(\d{3})(\d{3})(\d{3})(\d{2})/,
                            "$1.$2.$3-$4"
                        )}</td>
                    `;

            row.style.cursor = "pointer";

            Array.from(row.getElementsByTagName("td"))
                .filter((_, i) => i !== 0)
                .forEach((tdElem) => {
                    tdElem.setAttribute("data-bs-target", "#form-modal");
                    tdElem.setAttribute("data-bs-toggle", "modal");
                    tdElem.addEventListener("click", () =>
                        handleSetUpdateForm(item)
                    );
                });
        });
    } else if (endpoint === "products") {
        theadElement.append(
            createSortableHeader([
                { text: "", sortable: false },
                { text: "Nome", column: "name" },
                { text: "Preço", column: "price" },
                { text: "Código de barras", column: "barcode" },
            ])
        );

        items.forEach((item) => {
            const row = tbodyElement.insertRow();
            row.innerHTML = `
                        <td><input class="form-check-input" type="checkbox" value=${
                            item.id
                        }></td>
                        <td>${item.name}</td>
                        <td>${Intl.NumberFormat("pt-BR", {
                            style: "currency",
                            currency: "BRL",
                        }).format(+item.price)}</td>
                        <td>${item.barcode}</td>
                    `;

            row.style.cursor = "pointer";

            Array.from(row.getElementsByTagName("td"))
                .filter((_, i) => i !== 0)
                .forEach((tdElem) => {
                    tdElem.setAttribute("data-bs-target", "#form-modal");
                    tdElem.setAttribute("data-bs-toggle", "modal");
                    tdElem.addEventListener("click", () =>
                        handleSetUpdateForm(item)
                    );
                });
        });
    } else if (endpoint === "orders") {
        theadElement.append(
            createSortableHeader([
                { text: "", sortable: false },
                { text: "Nº", column: "id" },
                { text: "Cliente", column: "client_name" },
                { text: "Produto", column: "product_name" },
                { text: "Valor unit.", column: "product_price" },
                { text: "Quantidade", column: "quantity" },
                { text: "Desconto", column: "discount" },
                { text: "Valor total", column: "total" },
                { text: "Data do pedido", column: "order_date" },
                { text: "Status", column: "status" },
            ])
        );

        items.forEach((item) => {
            const productPrice = +item.product_price;
            const totalWithDiscount = productPrice * item.quantity;
            const total = totalWithDiscount - totalWithDiscount * item.discount;

            const discount = item.discount * 100;
            const discountPercentage =
                discount > 0 ? discount.toFixed(0) + "%" : "Nenhum";

            const formattedDate = toFormattedDate(item.order_date);

            const row = tbodyElement.insertRow();
            row.innerHTML = `
                        <td><input class="form-check-input" type="checkbox" value=${
                            item.id
                        }></td>
                        <td>#${item.id}</td>
                        <td>${item.client_name + " " + item.client_surname}</td>
                        <td>${item.product_name}</td>
                        <td>${toBRL(productPrice)}</td>
                        <td>${item.quantity}</td>
                        <td>${discountPercentage}</td>
                        <td>${toBRL(total)}</td>
                        <td>${formattedDate}</td>
                        <td>${orderStatusLabels[item.status]}</td>
                    `;

            row.style.cursor = "pointer";

            const clientTdElem = row.getElementsByTagName("td")[2];
            const productTdElem = row.getElementsByTagName("td")[3];

            clientTdElem.addEventListener("click", () => {
                window.location = "clientes/" + item.client_id;
            });

            productTdElem.addEventListener("click", () => {
                window.location = "produtos/" + item.product_id;
            });

            Array.from(row.getElementsByTagName("td"))
                .filter((_, i) => i !== 0 && i !== 2 && i !== 3)
                .forEach((tdElem, i, arr) => {
                    tdElem.setAttribute("data-bs-target", "#form-modal");
                    tdElem.setAttribute("data-bs-toggle", "modal");
                    tdElem.addEventListener("click", () =>
                        handleSetUpdateForm(item)
                    );
                });
        });
    }

    Array.from(tbodyElement.getElementsByTagName("input")).forEach((input) => {
        input.addEventListener("click", (e) => {
            e.stopPropagation();

            const { value, checked } = input;

            if (checked) selectedItems.push(value);
            else
                selectedItems = [
                    ...selectedItems.filter((item) => item != value),
                ];

            document.getElementById("remove-selected-btn").disabled =
                !selectedItems.length;
        });

        const { value } = input;

        if (selectedItems.includes(value) && !input.checked) input.click();
    });
}

function createSortableHeader(columns) {
    const trElement = document.createElement("tr");

    columns.forEach((col) => {
        if (!col.sortable && col.sortable !== undefined) {
            trElement.append(document.createElement("th"));

            return;
        } else {
            const isCurrentColumn = queryParams.sortByColumn === col.column;
            const currentSort = isCurrentColumn ? queryParams.sortByType : "";
            const nextSort = getNextSortType(currentSort);

            const sortIcon = getSortIcon(currentSort);
            const buttonClass = isCurrentColumn ? "sort-active" : "";

            const thElement = document.createElement("th");
            const buttonElement = document.createElement("button");

            buttonElement.classList.add("sort-btn");
            if (!!buttonClass) buttonElement.classList.add(buttonClass);
            buttonElement.textContent = `${col.text} ${sortIcon}`;

            const callback = function () {
                handleSort(col.column, nextSort);
            };
            buttonElement.addEventListener("click", callback);

            thElement.append(buttonElement);

            trElement.append(thElement);
        }
    });

    return trElement;
}

function getNextSortType(currentSort) {
    switch (currentSort) {
        case "":
            return "ASC";
        case "ASC":
            return "DESC";
        case "DESC":
            return "ASC";
        default:
            return "ASC";
    }
}

function getSortIcon(sortType) {
    switch (sortType) {
        case "ASC":
            return "▲";
        case "DESC":
            return "▼";
        default:
            return "↕";
    }
}

function handleSort(column, sortType) {
    queryParams.sortByColumn = column;
    queryParams.sortByType = sortType;

    queryParams.offset = 0;

    getItems();
}

function createPagination(total, currentPage = 0) {
    const totalPages = Math.ceil(total / queryParams.limit);
    const paginationElement = document.getElementById("pagination");
    paginationElement.innerHTML = "";

    createPageItems(totalPages, currentPage);
    createPrevAndNextButtons(totalPages, currentPage);
}

function createPageItems(totalPages, currentPage) {
    const paginationElement = document.getElementById("pagination");

    for (let i = 0; i < totalPages; i++) {
        const onClick = () => {
            queryParams.offset = i * queryParams.limit;

            getItems(endpoint, queryParams);
        };

        const pageItem = document.createElement("li");
        pageItem.className = "page-item";
        if (i === currentPage) {
            pageItem.classList.add("active");
        }
        pageItem.innerHTML = `<a class="page-link" data-page="${i}">${
            i + 1
        }</a>`;
        pageItem
            .getElementsByTagName("a")[0]
            .addEventListener("click", onClick);

        paginationElement.appendChild(pageItem);
    }
}

function createPrevAndNextButtons(totalPages, currentPage) {
    const paginationElement = document.getElementById("pagination");

    const onClickPrev = () => {
        if (currentPage > 0) {
            queryParams.offset = (currentPage - 1) * queryParams.limit;

            getItems(endpoint, queryParams);
        }
    };
    const onClickNext = () => {
        if (currentPage < totalPages - 1) {
            queryParams.offset = (currentPage + 1) * queryParams.limit;

            getItems(endpoint, queryParams);
        }
    };

    const prevItem = document.createElement("li");
    prevItem.className = "page-item" + (currentPage === 0 ? " disabled" : "");
    prevItem.innerHTML =
        '<a class="page-link aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
    prevItem
        .getElementsByTagName("a")[0]
        .addEventListener("click", onClickPrev);

    paginationElement.insertBefore(prevItem, paginationElement.firstChild);

    const nextItem = document.createElement("li");
    nextItem.className =
        "page-item" + (currentPage === totalPages - 1 ? " disabled" : "");
    nextItem.innerHTML =
        '<a class="page-link" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>';
    nextItem
        .getElementsByTagName("a")[0]
        .addEventListener("click", onClickNext);

    paginationElement.appendChild(nextItem);
}

function handleItemsPerPageChange() {
    document.getElementById("limit-switch").addEventListener("change", (e) => {
        queryParams.offset = 0;
        queryParams.limit = +e.target.value;

        getItems();
    });
}

function handleFilter() {
    const filterForm = document.getElementById("filter-form");

    filterForm.addEventListener("submit", (e) => {
        e.preventDefault();

        if (endpoint === "orders") {
            queryParams.filterByDate =
                document.getElementById("filter-by-date").value;
            queryParams.filterByStatus =
                document.getElementById("filter-by-status").value;
        }

        queryParams.filterByValue =
            document.getElementById("filter-by-value").value;

        queryParams.offset = 0;

        getItems();
    });
}

function handleCleanForm() {
    switch (endpoint) {
        case "clients": {
            document.getElementById("name").value = "";
            document.getElementById("surname").value = "";
            document.getElementById("email").value = "";
            document.getElementById("cpf").value = "";

            return;
        }
        case "products": {
            document.getElementById("name").value = "";
            document.getElementById("price").value = "";
            document.getElementById("barcode").value = "";

            return;
        }
        case "orders": {
            document.getElementById("client_id").value = "";
            document.getElementById("product_id").value = "";
            document.getElementById("quantity").value = "";
            document.getElementById("status").value = "";
            document.getElementById("order_date").value = "";
            document.getElementById("discount").value = "";

            return;
        }
    }
}

function handleSetUpdateForm(item) {
    selectedId = item.id;

    const titleElement = document.getElementById("form-title");
    titleElement.textContent = "Editar ";

    switch (endpoint) {
        case "clients": {
            titleElement.textContent = titleElement.textContent + "cliente";

            document.getElementById("name").value = item.name;
            document.getElementById("surname").value = item.surname;
            document.getElementById("email").value = item.email;
            document.getElementById("cpf").value = item.cpf;

            break;
        }
        case "products": {
            titleElement.textContent = titleElement.textContent + "produto";

            document.getElementById("name").value = item.name;
            document.getElementById("price").value = item.price.replace(
                ".",
                ","
            );
            document.getElementById("barcode").value = item.barcode;

            break;
        }
        case "orders": {
            titleElement.textContent = titleElement.textContent + "pedido";

            document.getElementById("client_id").value = item.client_id;
            document.getElementById("product_id").value = item.product_id;
            document.getElementById("quantity").value = item.quantity;
            document.getElementById("status").value = item.status;
            document.getElementById("order_date").value = toStringDate(
                item.order_date
            );
            document.getElementById("discount").value = (
                item.discount * 100
            ).toFixed(0);

            break;
        }
    }

    handleSetSubmitEvent("PUT");
}

function handleSetSubmitEvent(method) {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);
        form = newForm;

        const formData = new FormData(form);

        const object = {};
        formData.forEach(function (value, key) {
            switch (key) {
                case "price":
                    object[key] = (+value.replace(",", ".")).toFixed(2);
                    break;
                case "discount":
                    object[key] = (+value / 100).toFixed(2);
                    break;
                default:
                    object[key] = value;
                    break;
            }
        });
        const json = JSON.stringify(object);

        const endpointId = method === "PUT" ? "/" + selectedId : "";

        fetch(rootApiUrl + endpoint + endpointId, {
            method,
            body: json,
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then(async (response) => {
                const data = await response.json();

                if (!!data.error) throw data.error;

                if (method === "PUT") alert("Informações atualizadas!");
                else alert("Cadastro realizado!");

                getItems();

                closeModalElement.click();
            })
            .catch((error) => {
                const message = Object.values(error).join("\n");

                alert(message);
            });
    });
}
