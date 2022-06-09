import {hFetch} from "../../functions.js";

const deleteUserButtons=document.querySelectorAll(".delete-user");
deleteUserButtons.forEach(function(button){
    button.addEventListener("click",function(event){
        event.preventDefault(); // prevent the default action of the button
        const userId=button.dataset.id;

        const fd = new FormData();
        fd.append('userId', userId);

        hFetch('https://marci.dev/userController/delete', {
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

const updateUserButtons = document.querySelectorAll(".edit-user");
updateUserButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const userId = button.dataset.id;

        const fd = new FormData();
        const username= document.querySelector("#edit-username").value;
        const email= document.querySelector("#edit-email").value;
        const firstName= document.querySelector("#edit-firstName").value;
        const middleName= document.querySelector("#edit-middleName").value;
        const lastName= document.querySelector("#edit-lastName").value;
        const birthDate= document.querySelector("#edit-birthdate").value;
        const phoneNumber= document.querySelector("#edit-phoneNumber").value;
        const zipCode= document.querySelector("#edit-zip_code").value;
        const city= document.querySelector("#edit-city").value;
        const district= document.querySelector("#edit-district").value;
        const moreaddress= document.querySelector("#edit-moreAddress").value;
        const role=document.querySelector("#edit-role").value;

        fd.append('userId', userId);

        hFetch('https://marci.dev/userController/getUser', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                //document.querySelector("#edit-user-id").value = data.id;
                document.querySelector("#edit-username").value = data.username;
                document.querySelector("#edit-email").value = data.email;
                document.querySelector("#edit-firstName").value = data.first_name;
                document.querySelector("#edit-middleName").value = data.middle_name;
                document.querySelector("#edit-lastName").value = data.last_name;
                document.querySelector("#edit-birthdate").value = data.birth_date;
                document.querySelector("#edit-phoneNumber").value = data.phoneNumber;
                document.querySelector("#edit-zip_code").value = data.zip_code;
                document.querySelector("#edit-city").value = data.city;
                document.querySelector("#edit-district").value = data.district;
                document.querySelector("#edit-moreAddress").value = data.more_address;
                document.querySelector("#edit-role").value = data.role;
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});

const saveEditedDataButton= document.querySelector("#save-edited-data");
saveEditedDataButton.addEventListener("click", function (event) {


    const id= document.querySelector("#edit-user-id").value;
    const username= document.querySelector("#edit-username").value;
    const email= document.querySelector("#edit-email").value;
    const first_name= document.querySelector("#edit-firstName").value;
    const middle_name= document.querySelector("#edit-middleName").value;
    const last_name= document.querySelector("#edit-lastName").value;
    const birthdate= document.querySelector("#edit-birthdate").value;
    const phoneNumber= document.querySelector("#edit-phoneNumber").value;
    const zip_code= document.querySelector("#edit-zip_code").value;
    const city= document.querySelector("#edit-city").value;
    const district= document.querySelector("#edit-district").value;
    const more_address= document.querySelector("#edit-moreAddress").value;
    const role=document.querySelector("#edit-role").value;

    const fd = new FormData();

    fd.append('id', id);
    fd.append('username', username);
    fd.append('email', email);
    fd.append('first_name', first_name);
    fd.append('middle_name', middle_name);
    fd.append('last_name', last_name);
    fd.append('birth_date', birthdate);
    fd.append('phoneNumber', phoneNumber);
    fd.append('zip_code', zip_code);
    fd.append('city', city);
    fd.append('district', district);
    fd.append('more_address', more_address);
    fd.append('role',role);

    hFetch('https://marci.dev/userController/update', {
        method: 'POST', body: fd
    })
        .then(response => response.json())
        .then(data => {
            if (data === "success") {
                location.reload();
            }
        })
        .catch((error) => {
            console.log(error)
        });
});

const saveNewPassword= document.querySelector("#save-new-password");
saveNewPassword.addEventListener("click", function (event) {

    const password=document.querySelector("#save-new-password");


    const fd = new FormData();

    fd.append('password_hash',password);


    hFetch('https://marci.dev/userController/updatePassword', {
        method: 'POST', body: fd
    })
        .then(response => response.json())
        .then(data => {
            if (data === "success") {
                location.reload();
            }
        })
        .catch((error) => {
            console.log(error)
        });
});
