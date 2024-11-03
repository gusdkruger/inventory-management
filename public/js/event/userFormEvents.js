export function addUserFormEvents() {
    document.body.addEventListener("htmx:beforeSend", (event) => {
        const path = event.detail.requestConfig.path;
        if(path == "/login" || path == "/signup" || path == "/changeEmail" || path == "/changePassword") {
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

    document.body.addEventListener("invalidNewPassword", (event) => {
        const inputNewPassword = document.getElementById("input-new-password");
        inputNewPassword.classList.add("is-invalid");
        inputNewPassword.value = "";
        const newPasswordFeedback = document.getElementById("new-password-feedback");
        newPasswordFeedback.innerText = "New password must be between 6 and 255 characters";
    });

    document.body.addEventListener("invalidLoginInfo", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
        const passwordFeedback = document.getElementById("password-feedback");
        passwordFeedback.innerText = "Incorrect email or password";
    });

    document.body.addEventListener("wrongPassword", (event) => {
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
        const passwordFeedback = document.getElementById("password-feedback");
        passwordFeedback.innerText = "Confirm current password";
    });

    document.body.addEventListener("passwordsDidntMatch", (event) => {
        const inputPassword = document.getElementById("input-password");
        inputPassword.classList.add("is-invalid");
        inputPassword.value = "";
        const inputPasswordRepeat = document.getElementById("input-password-repeat");
        inputPasswordRepeat.classList.add("is-invalid");
        inputPasswordRepeat.value = "";
        const passwordRepeatFeedback = document.getElementById("password-repeat-feedback");
        passwordRepeatFeedback.innerText = "Passwords didn't match";
    });

    document.body.addEventListener("newPasswordsDidntMatch", (event) => {
        const inputNewPassword = document.getElementById("input-new-password");
        inputNewPassword.classList.add("is-invalid");
        inputNewPassword.value = "";
        const inputNewPasswordRepeat = document.getElementById("input-new-password-repeat");
        inputNewPasswordRepeat.classList.add("is-invalid");
        inputNewPasswordRepeat.value = "";
        const newPasswordRepeatFeedback = document.getElementById("new-password-repeat-feedback");
        newPasswordRepeatFeedback.innerText = "New passwords didn't match";
    });

    document.body.addEventListener("emailsDontMatch", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const inputEmailRepeat = document.getElementById("input-email-repeat");
        inputEmailRepeat.classList.add("is-invalid");
        const emailRepeatFeedback = document.getElementById("email-repeat-feedback");
        emailRepeatFeedback.innerText = "Emails don't match";
    });

    document.body.addEventListener("emailAlreadyBeingUsed", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const emailFeedback = document.getElementById("email-feedback");
        emailFeedback.innerText = "Email is already in use";
        const inputPassword = document.getElementById("input-password");
        inputPassword.value = "";
    });

    document.body.addEventListener("emailMustBeDifferent", (event) => {
        const inputEmail = document.getElementById("input-email");
        inputEmail.classList.add("is-invalid");
        const emailFeedback = document.getElementById("email-feedback");
        emailFeedback.innerText = "New email must be different";
        const inputPassword = document.getElementById("input-password");
        inputPassword.value = "";
    });
}
