document.addEventListener("DOMContentLoaded", function () {
    handleFormSubmit("#register-form", "/register", function (responseText) {
        window.location.href = "/"
    });
});
