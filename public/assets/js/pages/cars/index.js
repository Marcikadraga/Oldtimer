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

const updateCarButtons = document.querySelectorAll(".edit-car");
updateCarButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const carId = button.dataset.id;


        const fd = new FormData();
        fd.append('carId', carId);

        hFetch('https://marci.dev/CarController/getCar', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {

                document.querySelector("#edit-car-id").value = data.id;
                document.querySelector("#edit-type").value = data.type;
                document.querySelector("#edit-color").value = data.color;
                document.querySelector("#edit-kilometers-traveled").value = data.kilometers_traveled;
                document.querySelector("#edit-year-of-manufacture").value = data.year_of_manufacture;
                document.querySelector("#edit-car-condition").value = data.car_condition;
                document.querySelector("#edit-type-of-fuel").value = data.type_of_fuel;

                const colorElement = document.querySelector("#edit-color");
                colorElement.value = data.color;
                colorElement.style.backgroundColor = colorElement.value;
                $('#exampleModal').modal();
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });
});

const saveEditDataButton = document.querySelector("#save-edited-data2");
saveEditDataButton.addEventListener("click", function (event) {

    const carId = document.querySelector("#edit-car-id").value;
    const type = document.querySelector("#edit-type").value;
    const color = document.querySelector("#edit-color").value;
    const kilometers_traveled = document.querySelector("#edit-kilometers-traveled").value;
    const year_of_manufacture = document.querySelector("#edit-year-of-manufacture").value;
    const car_condition = document.querySelector("#edit-car-condition").value;
    const type_of_fuel = document.querySelector("#edit-type-of-fuel").value;


    const fd = new FormData();
    fd.append('carId', carId);
    fd.append('type', type);
    fd.append('color', color);
    fd.append('kilometers-traveled', kilometers_traveled);
    fd.append('year-of-manufacture', year_of_manufacture);
    fd.append('car-condition', car_condition);
    fd.append('type-of-fuel', type_of_fuel);
    hFetch('https://marci.dev/CarController/update', {
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



































