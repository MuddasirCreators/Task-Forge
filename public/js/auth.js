function togglePassword(inputId, eyeId) {

    const input = document.getElementById(inputId);

    if (!input) return;

    if (input.type === "password") {

        input.type = "text";

    } else {

        input.type = "password";

    }

}