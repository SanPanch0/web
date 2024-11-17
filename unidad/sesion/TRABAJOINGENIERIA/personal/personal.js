function toggleForm() {
    const form = document.getElementById("add-form");
    form.style.display = form.style.display === "none" ? "block" : "none";
}

function agregarPersonal() {
    const form = document.getElementById("nuevoPersonalForm");
    const formData = new FormData(form);

    fetch("personal/nuevo.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Mostrar mensaje de éxito o error
        form.reset(); // Limpiar el formulario
        cargarPersonal(); // Recargar la tabla
    })
    .catch(error => console.error("Error:", error));
}

function cargarPersonal() {
    fetch("personal/personal.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("tabla-personal").innerHTML = data;
        });
}
function toggleLicenciaFields() {
    const tipo = document.getElementById("tipo").value;
    const licenciaFields = document.getElementById("licencia-fields");
    if (tipo === "Conductor") {
        licenciaFields.style.display = "block";
    } else {
        licenciaFields.style.display = "none";
    }
}
