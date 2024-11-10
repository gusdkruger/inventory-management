document.body.addEventListener("htmx:beforeRequest", (event) => {
    const path = event.detail.requestConfig.path;
    if(path == "/login" || path == "/signup" || path == "/changeEmail" || path == "/changePassword" || path == "/deleteProfile") {
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
    if(event.detail.xhr.status >= 400 && event.detail.xhr.status < 500) {
        let body = JSON.parse(event.detail.xhr.response);
        for(let i = 0; i < body.length; i++) {
            const input = document.getElementById(body[i].input);
            if(body[i].valid == "false") {
                input.classList.add("is-invalid");
            }
            if(body[i].value == "reset") {
                input.value = "";
            }
            if(body[i].small) {
                const small = document.getElementById(body[i].small);
                small.innerText = body[i].text;
            }
        }
    }
});
