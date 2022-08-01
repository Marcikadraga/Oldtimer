import {hFetch} from "../../functions.js";

const deleteColorButtons = document.querySelectorAll(".delete-color");
deleteColorButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const colorId = button.dataset.id;

        const fd = new FormData();
        fd.append('colorId', colorId)

        hFetch('https://marci.dev/carController/deleteColor', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                if (data === "success") {
                    button.closest("tr").remove();
                }
            })
            .then(() => {
                alert("sikeres törlés")
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });

});







