document.addEventListener("DOMContentLoaded", () => {
    const loginBox = document.querySelector(".form-box.login");
    const registerBox = document.querySelector(".form-box.register");
    const toggleRight = document.querySelector(".toggle-panel.toggle-right");
    const toggleLeft = document.querySelector(".toggle-panel.toggle-left");
    const registerBtn = document.querySelector(".register-btn");
    const loginBtn = document.querySelector(".login-btn");

    // Mostrar login y panel derecho al cargar
    loginBox.style.visibility = "visible";
    toggleRight.style.visibility = "visible";
    registerBox.style.visibility = "hidden";
    toggleLeft.style.visibility = "hidden";

    // Cambiar a vista de registro
    registerBtn.addEventListener("click", () => {
        loginBox.style.visibility = "hidden";
        toggleRight.style.visibility = "hidden";
        registerBox.style.visibility = "visible";
        toggleLeft.style.visibility = "visible";
    });

    // Cambiar a vista de login
    loginBtn.addEventListener("click", () => {
        loginBox.style.visibility = "visible";
        toggleRight.style.visibility = "visible";
        registerBox.style.visibility = "hidden";
        toggleLeft.style.visibility = "hidden";
    });



    const inputText = document.getElementById('pss');
    inputText.addEventListener('input', function() {
        if (inputText.value.length > 8) {
            inputText.value = inputText.value.slice(0, 8); 
        }
    });
    

});



