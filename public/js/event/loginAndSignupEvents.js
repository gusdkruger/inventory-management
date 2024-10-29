export function addLoginAndSignupEvents() {
    document.body.addEventListener("htmx:beforeSend", (event) => {
        const path = event.detail.requestConfig.path;
        if(path === "/login" || path === "/signup") {
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

    document.body.addEventListener("invalidEmail", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const emailFeedback = document.getElementById("email-feedback");
        emailFeedback.innerText = "Email must be between 6 and 255 characters";
    });

    document.body.addEventListener("invalidPassword", (event) => {
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
        const passwordFeedback = document.getElementById("password-feedback");
        passwordFeedback.innerText = "Password must be between 6 and 255 characters";
    });

    document.body.addEventListener("invalidLoginInfo", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
    });

    document.body.addEventListener("passwordsDontMatch", (event) => {
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
        const inputPasswordRepeat = document.getElementById("input-password-repeat");
        inputPasswordRepeat.classList.add("is-invalid");
        inputPasswordRepeat.value = "";
        const passwordRepeatFeedback = document.getElementById("password-repeat-feedback");
        passwordRepeatFeedback.innerText = "Passwords don't match";
    });

    document.body.addEventListener("emailAlreadyBeingUsed", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const emailFeedback = document.getElementById("email-feedback");
        emailFeedback.innerText = "Email is already in use";
    });
}
