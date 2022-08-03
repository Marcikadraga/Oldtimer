import {hFetch} from "../../functions.js";

const deleteColorButtons = document.querySelectorAll(".delete-color");
deleteColorButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const colorId = button.dataset.id;

        const fd = new FormData();
        fd.append('colorId', colorId)

        hFetch('https://marci.dev/colorController/deleteColor', {
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

        hFetch('https://marci.dev/colorController/getColor', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                document.querySelector("#edit-color-id").value = data.id;
                document.querySelector("#edit-name-of-color").value = data.name_of_color;
                document.querySelector("#edit-rgb").value = data.rgb;
                document.querySelector("#Range0").value = data.r;
                document.querySelector("#Range1").value = data.g;
                document.querySelector("#Range2").value = data.b;

                let range0 = document.querySelector("#Range0").value = data.r;
                let range1 = document.querySelector("#Range1").value = data.g;
                let range2 = document.querySelector("#Range2").value = data.b;
                document.getElementById("resultColor").style.backgroundColor = "rgb(" + range0 + "," + range1 + "," + range2 + ")";

                $('#exampleModal').modal('show');
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });
});

// Az exampleModal eseménye: hidden.bs.modal akkor fut le, ha a modal bezáródik
$('#exampleModal')
    .on('shown.bs.modal', function () {
        $('#edit-name-of-color').trigger('focus');
    })
    .on('hide.bs.modal', function (e) {
        document.querySelector("#edit-color-id").value = '';
        document.querySelector("#edit-name-of-color").value = '';
        document.querySelector("#edit-rgb").value = '';
    });


const saveEditedDataButton = document.querySelector("#save-edited-data");
saveEditedDataButton.addEventListener("click", function (event) {

    const colorId = document.querySelector("#edit-color-id").value; //a carID alapján fogok szűrni backenden a kocsikat, és az egyező id-jű kocsi adatait frissíteni.
    const nameOfColor = document.querySelector("#edit-name-of-color").value;
    const rgb = document.querySelector("#edit-rgb").value;


    let range0 = document.getElementById("Range0");
    let range1 = document.getElementById("Range1");
    let range2 = document.getElementById("Range2");


    const fd = new FormData();
    fd.append('id', colorId);
    fd.append('name_of_color', nameOfColor);
    fd.append('rgb', "rgb(" + range0.value + "," + range1.value + "," + range2.value + ")");



    hFetch('https://marci.dev/ColorController/updateColor', {
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





