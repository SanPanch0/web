function agregarUnidad() {
    const form = document.getElementById('nuevaUnidadForm');
    const formData = new FormData(form);
    
    fetch('unidades/nuevoc.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Muestra el mensaje devuelto por el PHP
        if (data.includes("añadida exitosamente")) {
            location.reload(); // Refresca la página solo si se añade correctamente
        }
    })
    .catch(error => console.error('Error:', error));
}
