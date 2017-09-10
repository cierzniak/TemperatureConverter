const trans = $(".js-trans");
const apiRequest = (unit, value) => {
    $.ajax({
        url: '/api/v1/converter/' + unit + '/' +  value,
        type: 'GET',
        success: (response) => {
            $("#alert").html("");
            $("#results").html(createResultsTable(response.data.converted));

        },
        error: (response) => {
            $("#alert").html(createAlert(response.responseJSON.error.message));
            $("#results").html("");
        }
    });
};
const createResultsTable = (converted) => {
    let table = document.createElement('table');
    table.classList.add("table");

    let head = table.createTHead();
    head.classList.add("thead-default");
    let headRow = head.insertRow();
    headRow.insertCell(0).outerHTML = "<th class='text-center'>" + trans.data('unit') + "</th>";
    headRow.insertCell(1).outerHTML = "<th class='text-center'>" + trans.data('value') + "</th>";

    let body = table.appendChild(document.createElement('tbody'));
    Object.keys(converted).forEach((key) => {
        let bodyRow = body.insertRow();
        bodyRow.insertCell(0).innerHTML = key;
        bodyRow.insertCell(1).innerHTML = converted[key].toFixed(4);
    });

    return table;
};
const createAlert = (message) => {
    let alert = document.createElement('div');
    alert.classList.add("alert");
    alert.classList.add("alert-danger");
    alert.innerHTML = message;
    return alert;
};

window.addEventListener("load", () => {
    let form = document.getElementById("needs-validation");
    form.addEventListener("submit", (event) => {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            apiRequest(form.elements['unit'].value, form.elements['value'].value)
        }
        form.classList.add("was-validated");
    }, false);
}, false);