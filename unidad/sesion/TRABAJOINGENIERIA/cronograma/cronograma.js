let currentDate = new Date();
const services = {}; // Objeto para almacenar los servicios

function renderCalendar() {
    const monthYear = document.getElementById("month-year");
    const currentMonthYear = document.getElementById("current-month-year");
    const dateContainer = document.getElementById("date-container");

    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();
    
    monthYear.textContent = `Calendario de ${currentDate.toLocaleString('default', { month: 'long', year: 'numeric' })}`;
    currentMonthYear.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} de ${year}`;

    // Limpiar el contenedor
    dateContainer.innerHTML = '';

    // Obtener el primer día del mes y el número total de días
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Crear espacios vacíos para los días del mes anterior
    for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        emptyDiv.classList.add("date", "empty");
        dateContainer.appendChild(emptyDiv);
    }

    // Crear los días del mes
    for (let day = 1; day <= daysInMonth; day++) {
        const dateDiv = document.createElement("div");
        dateDiv.classList.add("date");
        dateDiv.textContent = day;
        dateDiv.addEventListener("click", () => selectDate(day));

        // Marcar días seleccionados
        if (services[`${year}-${month + 1}-${day}`]) {
            dateDiv.classList.add("selected");
            const count = services[`${year}-${month + 1}-${day}`].length;
            dateDiv.textContent += ` (${count})`; // Mostrar el número de servicios
        }

        dateContainer.appendChild(dateDiv);
    }
}

function selectDate(day) {
    const dateKey = `${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${day}`;
    
    if (!services[dateKey]) {
        services[dateKey] = [];
    }

    // Mostrar el formulario
    const form = document.getElementById("service-form");
    form.style.display = "block";

    // Manejar el envío del formulario
    const formElement = document.getElementById("form");
    formElement.onsubmit = (event) => {
        event.preventDefault();
        
        const unit = document.getElementById("unit").value;
        const driver = document.getElementById("driver").value;
        const helpers = document.getElementById("helpers").value;
        const materials = document.getElementById("materials").value;
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;

        // Guardar el servicio
        services[dateKey].push({ unit, driver, helpers, materials, startDate, endDate });
        
        // Actualizar el calendario
        renderCalendar();
        
        // Reiniciar el formulario
        formElement.reset();
    };
}

function changeMonth(direction) {
    currentDate.setMonth(currentDate.getMonth() + direction);
    renderCalendar();
}

function changeYear(direction) {
    currentDate.setFullYear(currentDate.getFullYear() + direction);
    renderCalendar();
}

// Llamar a renderCalendar al cargar la página
renderCalendar();
