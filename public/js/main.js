import { addLoginAndSignupEvents } from "./event/loginAndSignupEvents.js";

addLoginAndSignupEvents();

function showOverlay() {
    document.getElementById("overlay").style.display = "flex";
}

function closeOverlay() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("overlay").innerHTML = "";
}