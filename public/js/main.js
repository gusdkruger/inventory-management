document.body.addEventListener("htmx:beforeRequest", (event) => {
    if(event.detail.requestConfig.target.tagName == "FORM") {
        const inputs = event.detail.elt.querySelectorAll("input");
        inputs.forEach(input => {
            input.classList.remove("is-invalid");
        });
        const smalls = event.detail.elt.querySelectorAll("small");
        smalls.forEach(small => {
            small.innerText = "";
        });
    }
});

document.body.addEventListener("htmx:afterRequest", (event) => {
    const targetTagName = event.detail.target.tagName;
    if(targetTagName == "FORM") {
        let body = JSON.parse(event.detail.xhr.response);
        for(let i = 0; i < body.length; i++) {
            if(body[i].input) {
                const input = document.getElementById(body[i].input);
                if(body[i].valid == "false") {
                    input.classList.add("is-invalid");
                }
                if(body[i].value == "reset") {
                    input.value = "";
                }
            }
            if(body[i].small && body[i].text) {
                const small = document.getElementById(body[i].small);
                small.innerText = body[i].text;
            }
        }
    }
    else if(targetTagName == "TBODY") {
        const loadingElement = event.detail.requestConfig.elt;
        const tbody = event.detail.target;
        const items = JSON.parse(event.detail.xhr.response);
        let content = "";
        items.forEach(item => {
            content += `
            <tr>
                <th scope="row">${item.id}</th>
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>${item.location}</td>
                <td>${item.description}</td>
                <td>EDIT</td>
                <td><button class="btn btn-outline-danger" hx-post="/deleteItem" hx-vals='{"id": "${item.id}"}'>Delete</button></td>
            </tr>`;
        });
        tbody.innerHTML = content;
        loadingElement.remove();
        htmx.process(tbody);
    }
    else if(targetTagName == "BUTTON" && event.detail.requestConfig.path == "/deleteItem" && event.detail.xhr.status == 200) {
        const tr = event.detail.target.parentElement.parentElement;
        tr.remove();
    }
    else if(event.detail.requestConfig.path == "/addItem" && event.detail.xhr.status == 200) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(event.detail.target)
        toastBootstrap.show();
    }
});
