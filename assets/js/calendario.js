// fechas viene de PHP (JSON)
const datos = fechas; // { "2025-05-10": {cantidad: 3, horas: 5}, ... }

const fecha = new Date();
const anio = fecha.getFullYear();
const mes = fecha.getMonth(); // 0-11
const diasMes = new Date(anio, mes + 1, 0).getDate();

const calendario = document.getElementById('calendario');

// Crear calendario
for (let dia = 1; dia <= diasMes; dia++) {
    const fechaActual = new Date(anio, mes, dia);
    const fechaStr = fechaActual.toISOString().split("T")[0];

    const nombreDia = fechaActual.getDay(); // domingo = 0
    let clase = "verde";

    if (nombreDia === 0) {
        clase = "rojo"; // domingo
    }

    if (datos[fechaStr]) {
        const { cantidad, horas } = datos[fechaStr];

        if (cantidad >= 5 || horas > 8) {
            clase = "rojo";
        } else if (cantidad >= 1 || horas <= 6) {
            clase = "amarillo";
        }
    }

    const div = document.createElement("div");
    div.className = `dia ${clase}`;
    div.innerHTML = `<strong>${dia}</strong><br>${datos[fechaStr] ? datos[fechaStr].cantidad + ' mudanzas' : 'Libre'}`;
    calendario.appendChild(div);
}