import {hFetch} from "../../functions.js";


const deleteCarButtons = document.querySelectorAll(".delete-carType");
deleteCarButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // prevent the default action of the button
        const carId = button.dataset.id;

        const fd = new FormData();
        fd.append('carId', carId);


        hFetch('https://marci.dev/CarTypeController/delete', {
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


const updateCarButtons = document.querySelectorAll(".edit-carType");
updateCarButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const carId = button.dataset.id;

        const fd = new FormData();
        fd.append('carId', carId);

        hFetch('https://marci.dev/CarTypeController/getCar', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                document.querySelector("#edit-car-id").value = data.id;
                document.querySelector("#edit-manufacturer").value = data.manufacturer;
                document.querySelector("#edit-type").value = data.type;
                document.querySelector("#edit-startOfProduction").value = data.startOfProductionTime;
                document.querySelector("#edit-endOfProduction").value = data.endOfProductionTime;
                $('#exampleModal').modal();
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });
});

const saveEditedDataButton= document.querySelector("#save-edited-data");
saveEditedDataButton.addEventListener("click", function (event) {

        const carId = document.querySelector("#edit-car-id").value; //a carID alapján fogok szűrni backenden a kocsikat, és az egyező id-jű kocsi adatait frissíteni.
        const manufacturer = document.querySelector("#edit-manufacturer").value;
        const type = document.querySelector("#edit-type").value;
        const startOfProduction = document.querySelector("#edit-startOfProduction").value;
        const endOfProduction = document.querySelector("#edit-endOfProduction").value;

        const fd = new FormData();
        fd.append('carId', carId);
        fd.append('manufacturer', manufacturer);
        fd.append('type', type);
        fd.append('startOfProduction', startOfProduction);
        fd.append('endOfProduction', endOfProduction);



    hFetch('https://marci.dev/CarTypeController/update', {
        method: 'POST', body: fd
    })
        .then(response => response.json())
        .then(data => {
            if (data === "success") {
                location.reload();
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
});




















