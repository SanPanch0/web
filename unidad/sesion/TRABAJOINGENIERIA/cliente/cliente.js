 function toggleForm() {
    const form = document.getElementById("add-form");
    form.style.display = form.style.display === "none" ? "block" : "none";
}

function agregarCliente() {
    const form = document.getElementById("nuevoClienteForm");
    const formData = new FormData(form);

    fetch("cliente/nuevoc.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Mostrar mensaje de éxito o error
        form.reset(); // Limpiar el formulario
        cargarClientes(); // Recargar la tabla de clientes
    })
    .catch(error => console.error("Error:", error));
}

function cargarClientes() {
    fetch("cliente/cliente.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("tabla-clientes").innerHTML = data;
        });
}

function toggleClientFields() {
    const tipo = document.getElementById("tipo").value;
    document.getElementById("dni-field").style.display = tipo === "Persona Natural" ? "block" : "none";
    document.getElementById("ruc-field").style.display = tipo === "Persona Jurídica" ? "block" : "none";
    document.getElementById("razon-social-field").style.display = tipo === "Persona Jurídica" ? "block" : "none";
    document.getElementById("sexo-field").style.display = tipo === "Persona Natural" ? "block" : "none";
    document.getElementById("fecha-nacimiento-field").style.display = tipo === "Persona Natural" ? "block" : "none";
}
