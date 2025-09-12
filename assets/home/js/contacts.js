

document.addEventListener("DOMContentLoaded", function() {
    const captchaUrl = window.contactConfig.captchaUrl;
    const contactUrl = window.contactConfig.contactSubmitUrl;

    initContactForm('homecontact', contactUrl, 'home-captcha-img', captchaUrl);
    initContactForm('contactform', contactUrl, 'contact-captcha-img', captchaUrl);
});

function initContactForm(formId, contactUrl, captchaId, captchaUrl) {
    const form = document.getElementById(formId);
    const captchaImg = document.getElementById(captchaId);
    const alertBox = document.getElementById("custom-alert");
    const alertText = document.getElementById("custom-alert-text");

    function showAlert(message, type = "success") {
        if (!alertBox || !alertText) return;
        alertText.textContent = message;
        alertBox.style.backgroundColor = type === "success" ? "#1ed84aff" : "#d82436ff";
        alertBox.style.display = "block";

        setTimeout(() => {
            alertBox.style.display = "none";
        }, 4000);
    }

    if (captchaImg) {
    const refreshCaptcha = () => {
        captchaImg.src = window.contactConfig.captchaUrl + "?" + Math.random();
    };
    captchaImg.addEventListener("click", refreshCaptcha);
    captchaImg.addEventListener("error", refreshCaptcha);
}

    if (form) {
    const inputs = form.querySelectorAll("input, textarea");
        inputs.forEach(input => {
            input.addEventListener("input", function() {
                const errorSpan = form.querySelector(`.error-${input.name}`);
                if (errorSpan) {
                    errorSpan.textContent = "";
                }
            });
        });

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            form.querySelectorAll("span.text-danger").forEach(el => el.textContent = "");

            axios.post(contactUrl, formData)
                .then(response => {
                    if (response.data.status === true) {
                        showAlert(response.data.message || "Thank you! Your message has been sent.", "success");
                        form.reset();
                        if (captchaImg) captchaImg.src = captchaUrl + "?" + Math.random();
                    } else {
                        const errors = response.data.errors || {};
                        if (errors.captcha && errors.captcha.includes("Invalid captcha.")) {
                            showAlert("Invalid captcha. Please try again.", "error");
                        }
                        for (const field in errors) {
                            const errorSpan = form.querySelector(`.error-${field}`);
                            if (errorSpan) errorSpan.textContent = errors[field][0];
                        }
                        //  if (response.data.message && !errors.captcha) {
                        //     showAlert(response.data.message, "error");
                        // }
                    }
                })
                // .catch(() => {
                //     showAlert("Something went wrong. Please try again later.", "error");
                // });
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const captchaUrl = "{{ url('/captcha-image') }}";
    initContactForm('homecontact', "{{ route('contact.submit') }}", 'home-captcha-img', captchaUrl);
    initContactForm('contactform', "{{ route('contact.submit') }}", 'contact-captcha-img', captchaUrl);
});




