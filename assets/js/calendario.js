document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        events: {
            url: 'assets/js/eventos.php', // Ruta correcta desde inicio.php
            failure: function () {
                alert('Error al cargar los eventos.');
            }
        },
        loading: function (isLoading) {
            if (isLoading) {
                console.log('Cargando eventos...');
            }
        },
        dateClick: function (info) {
            calendar.changeView('timeGridDay', info.dateStr);
        },
        eventDidMount: function (info) {
            if (info.event.title) {
                new bootstrap.Tooltip(info.el, {
                    title: info.event.title,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        }
    });

    calendar.render();
});
