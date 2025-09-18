<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: false, // No se permite arrastrar para seleccionar
                slotDuration: '01:00:00', // Cada franja es 1 hora
                selectMirror: true, // Efecto visual al seleccionar
                locale: 'es', // <-- Esto pone el calendario en español
                select: function(info) {
                    // info.start / info.end => horas seleccionadas
                    const title = prompt('Nombre de la cita:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: info.start,
                            end: info.end
                        });
                    }
                    calendar.unselect(); // Deselecciona la franja
                },
                eventClick: function(info) {
                    console.log(info);
                    alert(`Evento: ${info.event.title}\nHora: ${info.event.start.toLocaleTimeString()} - ${info.event.end ? info.event.end.toLocaleTimeString() : ''}`);
                },
                events: [{
                        title: 'Reunión',
                        start: '2025-09-18T10:00',
                        end: '2025-09-18T11:00'
                    },
                    {
                        title: 'Almuerzo',
                        start: '2025-09-18T13:00'
                    },
                    {
                        title: 'Cumpleaños',
                        start: '2025-09-20',
                        allDay: true
                    }
                ],
                dateClick: function(info) {
                    calendar.changeView('timeGridDay', info.dateStr);
                }
            });
            calendar.render();
        });
    </script>
</head>

<body>
    <div id='calendar'></div>
</body>

</html>