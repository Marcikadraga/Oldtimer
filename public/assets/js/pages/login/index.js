import {hFetch} from "../../functions.js";

const loginButton = document.querySelector("#login-user-button")
loginButton.addEventListener("click", myFunction);


function myFunction(e) {
    e.preventDefault() // megelőzzük- > nem csinálja meg
    setTimeout(() => {
        const loginForm = document.querySelector("#login-form");
        console.log("Buzi");
        loginForm.submit();


    }, 3000);
}

// document.getElementById("login-user-button").onclick = function () {
//     location.href = "www.yoursite.com";
// };


