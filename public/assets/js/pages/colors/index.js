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


const updateCarColor = document.querySelectorAll(".edit-color");
updateCarColor.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const colorId = button.dataset.id;

        const fd = new FormData();
        fd.append('colorId', colorId);

        hFetch('https://marci.dev/CarController/getColor', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                document.querySelector("#edit-color-id").value = data.id;
                document.querySelector("#edit-name-of-color").value = data.manufacturer;
                document.querySelector("#edit-rgb").value = data.type;
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });
});







