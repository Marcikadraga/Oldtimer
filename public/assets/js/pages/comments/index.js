import {hFetch} from "../../functions.js";


const deleteComment = document.querySelectorAll(".delete-comment");
deleteComment.forEach(function (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // prevent the default action of the button
        const commentId = button.dataset.id;

        const fd = new FormData();
        fd.append('commentId', commentId);


        hFetch('https://marci.dev/ForumController/delete', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {
                if (data === "success") {
                    let comment = document.getElementById(commentId);
                    comment.remove();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});

const editCommentButtons = document.querySelectorAll(".edit-comment");
editCommentButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const commentId = button.dataset.id;


        const fd = new FormData();
        fd.append('commentId', commentId);


        hFetch('https://marci.dev/ForumController/getComment', {
            method: 'POST', body: fd
        })
            .then(response => response.json())
            .then(data => {

                document.querySelector("#edit-comment-id").value = data.id;
                document.querySelector("#edit-uid").value = data.user_id;
                document.querySelector("#edit-message").value = data.message;

                $('#exampleModal').modal();
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    });
});

const saveEditedDataButton = document.querySelector("#save-edited-data");
saveEditedDataButton.addEventListener("click", function (event) {

    const commentId = document.querySelector("#edit-comment-id").value;
    const comment = document.querySelector("#edit-message").value;
    const uId = document.querySelector("#edit-uid").value;

    const fd = new FormData();
    fd.append('id', commentId);
    fd.append('message', comment);
    fd.append('user_id', uId);

    hFetch('https://marci.dev/ForumController/update', {
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

const addComment = document.querySelectorAll(".add-comment");
addComment.forEach(comment => {
    comment.addEventListener("click", function (event) {
        event.preventDefault();

        const element = event.target;


        //input
        let input = document.createElement('input');
        input.type="text";
        input.className="form-control";
        input.placeholder="Megjegyzés..";
        
        //button
        let sendBtn=document.createElement("button");
        sendBtn.innerHTML="Küldés";
        sendBtn.className="btn btn-outline-primary ml-auto text-center";
        sendBtn.style.marginTop="10px";

        //inputContainer
        let inputContainer = document.createElement('div');
        inputContainer.className = "form-group";
        inputContainer.appendChild(input);
        inputContainer.appendChild(sendBtn);

        //id-t elérjük
        const closestId = element.closest(".comment-row").id;
        console.log(closestId)

        //disable reply btn
        let reply=document.getElementById("reply"+closestId)
        reply.disabled="true";
        reply.style.backgroundColor="lightblue";

        //elemet hozzátesszük
        document.getElementById(closestId).appendChild(inputContainer);

    })
})

