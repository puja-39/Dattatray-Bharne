document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contact_form");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault(); 

            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    swal("Good job!", data.message, "success");
                    form.reset();
                } else {
                    swal("Oops!", data.message.join("\n"), "error");
                    if (data.message.length > 0) {
                        let firstInput = form.querySelector("input[required], textarea[required]");
                        if (firstInput) firstInput.focus();
                    }
                }
            })
            .catch(error => {
                swal("Error", "Something went wrong. Please try again.", "error");
                console.error(error);
            });
        });
    }
});
