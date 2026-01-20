const contactForm = document.querySelector("#contact-form");
const emailInput = document.getElementById("emailInput");
const nameInput = document.getElementById("nameInput");
const agreeCheckbox = document.getElementById("agree");
const errorMsg = document.getElementById("emailError");

const emailRegExp = /^[a-zA -Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

const checkValidity = () => {
    const isEmailValid = emailRegExp.test(emailInput.value.trim());
    const isNameValid = nameInput.value.trim().length >= 2;
    const isAgreed = agreeCheckbox.checked;
    return isEmailValid && isNameValid && isAgreed;
};

contactForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = {
        name: nameInput.value,
        email: emailInput.value,
        message: document.getElementById("messageInput").value
    };

    try {
        const response = await fetch('./send_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        if (response.ok) {
            alert("Success!");
            contactForm.reset();
        } else {
            alert("Failed to send.");
        }
    } catch (error) {
        console.error("Error:", error);
    }
});
