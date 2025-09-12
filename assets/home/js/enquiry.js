
window.showAlert = function (message) {
    const alertBox = document.getElementById("custom-alert");
    const alertText = document.getElementById("custom-alert-text");
    if (!alertBox || !alertText) return;

    alertText.textContent = message;
    alertBox.style.backgroundColor = '#13e243ff';
    alertBox.style.display = 'block';
    alertBox.style.opacity = '1';
    alertBox.style.transition = 'opacity 0.5s';

    setTimeout(() => {
        alertBox.style.opacity = '0';
        setTimeout(() => alertBox.style.display = 'none', 500);
       }, 4000);
    };
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("subscribe_user");
    if (!form) return;    
    const emailInput = form.querySelector('input[name="newsletter_email"]');
    const emailError = form.querySelector('.error-newsletter_email');
    if (emailInput && emailError) {
        emailInput.addEventListener('input', function () {
            emailError.textContent = '';
        });
    }
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        document.querySelectorAll("span.text-danger").forEach(el => el.textContent = ""); 
        axios.post(window.routes.subscribe, formData)
            .then(function (response) {
                console.log("Axios response:", response.data);
                if (response.data.status === true) {
                    showAlert(response.data.message || "Subscription successful!");
                    form.reset();
                } 
                else if (response.data.errors) {
                    for (const [field, messages] of Object.entries(response.data.errors)) {
                        let errorSpan = document.querySelector(`.error-${field}`);
                        if (errorSpan) {
                            errorSpan.textContent = messages[0];
                        }
                    }
                }
            })
            .catch(function (error) {
                console.error("Axios error:", error);
            });
    });
});
 