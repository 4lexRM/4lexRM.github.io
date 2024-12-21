document.addEventListener('DOMContentLoaded', (event) => {
    var accountButton = document.querySelector('.list-button-click');
    var accountSubmenu = document.querySelector('.list-show');
    var logoutLink = document.getElementById('logout');
    var consultLink = document.getElementById('consultAcc');
    var updateLink = document.getElementById('updateAcc');
    var deleteLink = document.getElementById('deleteAcc');
    var subjectsLink = document.getElementById('subjects');
    var submitButton = document.getElementById('btnAcc');
    var inputFields = document.querySelectorAll('.form-box .input-box input');
    var formBox = document.querySelector('.form-box');
    var subjectsSection = document.querySelector('.cont-subj');

    var btnSubj = document.getElementById('btnSubj');
    var addSubj = document.querySelector('.add-sub');
    var subjects = document.querySelector('.subjects');

    var btnAddSubj = document.getElementById('btnAddSubj');
    var inputsSubj = document.querySelectorAll('.cont-subj .add-sub input');


    // Función para mostrar la sección de "form-box" y ocultar la sección de "Subjects"
    function showFormBox() {
        formBox.style.display = 'block';
        subjectsSection.style.display = 'none';
    }

    accountButton.addEventListener('click', () => {
        if (accountSubmenu.style.display == 'block') {
            accountSubmenu.style.display = 'none';
            accountButton.classList.remove('active');
        } else {
            accountSubmenu.style.display = 'block';
            accountButton.classList.add('active');
        }
    });

    logoutLink.addEventListener('click', (event) => {
        event.preventDefault();
        var confirmLogout = confirm("¿Estás seguro que deseas cerrar sesión?");
        if (confirmLogout) {
            window.location.href = 'index.php';
        }
    });

    consultLink.addEventListener('click', (event) => {
        event.preventDefault();
        submitButton.name = "btn-con";
        submitButton.value = "GoBack";
        submitButton.style.backgroundColor = "lightcoral"; // Color rojo claro
        
        // Hacer los campos de entrada de solo lectura
        inputFields.forEach((input) => {
            input.readOnly = true;
        });

        showFormBox();
    });

    updateLink.addEventListener('click', (event) => {
        event.preventDefault();
        submitButton.name = "btn-upd";
        submitButton.value = "Update";
        submitButton.style.backgroundColor = "#7494ec"; // Color normal
        
        // Hacer los campos de entrada editables
        inputFields.forEach((input) => {
            input.readOnly = false;
        });

        showFormBox();
    });

    deleteLink.addEventListener('click', (event) => {
        event.preventDefault();
        submitButton.name = "btn-del";
        submitButton.value = "Delete";
        submitButton.style.backgroundColor = "lightcoral"; // Color normal
        
        // Hacer los campos de entrada de solo lectura
        inputFields.forEach((input) => {
            input.readOnly = true;
        });

        showFormBox();
    });

    subjectsLink.addEventListener('click', (event) => {
        formBox.style.display = 'none';
        subjectsSection.style.display = 'block';
        addSubj.style.display = 'none';
        subjects.style.display = 'block';
    });

    // Lógica para mostrar "add-sub" y ocultar "subjects" al hacer clic en el botón
    btnSubj.addEventListener('click', () => {
        if (addSubj.style.display == 'none' || addSubj.style.display == '') {
            addSubj.style.display = 'block';
            subjects.style.display = 'none';
        }
    });

});
