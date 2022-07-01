import {hFetch} from "../../functions.js";

const deleteUserButtons = document.querySelectorAll(".delete-car");
deleteUserButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // prevent the default action of the button
        const carId = button.dataset.id;

        const fd = new FormData();
        fd.append('carId', carId);

        hFetch('https://marci.dev/carController/delete', {
            method: 'POST',
            body: fd
        })
            .then(response => response.json())
            .then(data => {
                if (data === "success") {
                    button.closest("tr").remove();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});
