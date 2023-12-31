document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.querySelector('#save');
    saveButton?.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-edit-modal');
    });

    const deleteButton = document.querySelector('#delete');
    deleteButton?.addEventListener('click', function (e) {
        e.preventDefault();
        handleOpen('#confirm-delete-modal');
    });

    const confirmEditButton = document.querySelector('#confirm-edit-btn');
    confirmEditButton?.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.querySelector("#review-form");
        submitForm(form, window.location.href, function (responseText) {
            window.location.href = "/my-reviews";
        })
        handleClose('#confirm-edit-modal');
    });

    const confirmCancelButton = document.querySelector('#confirm-cancel-btn');
    confirmCancelButton?.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = window.location.href.replace(/\/\w+$/, '');
    });

    const confirmDeleteButton = document.querySelector('#confirm-delete-btn');
    confirmDeleteButton?.addEventListener('click', function (e) {
        e.preventDefault();
        const xhr = new XMLHttpRequest();
        const url = window.location.href;
        xhr.open('DELETE', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) { // Check if the request is complete
                if (xhr.status === 200) {
                    window.location.href = '/my-reviews';
                } else {
                    alert('Failed to delete review');
                }
            }
        };
        xhr.send();
    });
});

function sendRequest(query) {
    const xhr = new XMLHttpRequest();
    const url = `/my-reviews/search?${query}`;
    xhr.open('GET', url);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('rl1').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
function handlePageChange(page) {
    const query = `page=${page}&take=5`;
    sendRequest(query);
}
