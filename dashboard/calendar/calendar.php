<?php
 
// include 'utils.php';
 
$id_doctor_appointment = $_GET['doctor'] ?? '';
$id_patient_appointment = $_GET['patient'] ?? '';
 
$today = time();
 
$first_month_day = strtotime(date("Y-m-01 00:00:00", $today));
 
$last_month_day = strtotime(date("Y-m-t 23:59:59", $today));
 
$mock_appointments_db = [
    ['id_appointment' => 20, 'date_appointment' => '2025-09-17', 'time_appointment' => '09:30:00', 'id_doctor_appointment' => 1, 'id_patient_appointment' => 3, 'status_appointment' => 'Confirmada'],
    ['id_appointment' => 1, 'date_appointment' => '2025-09-20', 'time_appointment' => '09:30:00', 'id_doctor_appointment' => 1, 'id_patient_appointment' => 3, 'status_appointment' => 'Confirmada'],
    ['id_appointment' => 2, 'date_appointment' => '2025-09-20', 'time_appointment' => '10:15:00', 'id_doctor_appointment' => 2, 'id_patient_appointment' => 1, 'status_appointment' => 'Pendiente'],
    ['id_appointment' => 3, 'date_appointment' => '2025-09-21', 'time_appointment' => '11:00:00', 'id_doctor_appointment' => 3, 'id_patient_appointment' => 4, 'status_appointment' => 'Cancelada'],
    ['id_appointment' => 4, 'date_appointment' => '2025-09-21', 'time_appointment' => '15:30:00', 'id_doctor_appointment' => 1, 'id_patient_appointment' => 2, 'status_appointment' => 'Confirmada'],
    ['id_appointment' => 5, 'date_appointment' => '2025-09-22', 'time_appointment' => '08:45:00', 'id_doctor_appointment' => 4, 'id_patient_appointment' => 5, 'status_appointment' => 'Pendiente']
];
 
$mock_appointments_transform = [];
 
foreach ($mock_appointments_db as $appointment) {
    $dateTime = $appointment['date_appointment'] . 'T' . $appointment['time_appointment'];
 
    $mock_appointments_transform[] = [
        'title' => 'Paciente ' . $appointment['id_patient_appointment'] . ' - ' . $appointment['status_appointment'],
        'start' => $dateTime,
        'extendedProps' => [
            'id' => $appointment['id_appointment'],
            'id_patient_appointment' => $appointment['id_patient_appointment'],
            'id_doctor_appointment' => $appointment['id_doctor_appointment'],
            'status' => $appointment['status_appointment'],
        ]
    ];
}
 
$mock_appointments_transform = json_encode($mock_appointments_transform);
 
?>
<!DOCTYPE html>
<html lang='es'>
 
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
    <script>
        const hoy = new Date().setHours(0, 0, 0, 0);
 
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: false,
                slotDuration: '01:00:00',
                selectMirror: true,
                locale: 'es',
                eventClick: function(info) {
                    if (info.view.type === "dayGridMonth") {
                        return;
                    }
 
                    const fechaClick = info.event.start;
 
                    fechaClick.setHours(0, 0, 0, 0);
 
                    if (fechaClick < hoy) {
                        alert("No puedes crear eventos en fechas pasadas");
                        return;
                    }
 
                    remove = confirm("Desea eliminar esta cita?")
                    if (remove) {
                        really = confirm("Esta realmente seguro?")
                        if (really) {
                            info.event.remove();
                            alert('cita eliminada');
                            alert(
                                `Evento: ${info.event.title}\n` +
                                `ID interno: ${info.event.extendedProps.id}\n` +
                                `Paciente: ${info.event.extendedProps.id_patient_appointment}\n` +
                                `Doctor: ${info.event.extendedProps.id_doctor_appointment}`
                            );
                            alert(`remove?id=${info.event.extendedProps.id}`);
                        }
                    }
                },
                events: <?= $mock_appointments_transform ?>,
                dateClick: function(info) {
                    if (info.view.type === "dayGridMonth") {
                        calendar.changeView('timeGridDay', info.dateStr);
                    } else if (info.view.type === "timeGridDay") {
 
                        const fechaClick = info.date;
 
                        fechaClick.setHours(0, 0, 0, 0);
 
                        if (fechaClick < hoy) {
                            alert("No puedes crear eventos en fechas pasadas");
                            return; // No hace nada
                        }
 
                        const title = prompt('Nombre de la cita:');
                        if (title) {
                            console.log(info);
                            calendar.addEvent({
                                title: title,
                                start: info.dateStr,
                            });
 
                            alert(
                                `Evento: ${info.event.title}\n` +
                                `ID interno: ${info.event.extendedProps.id}\n` +
                                `Paciente: ${info.event.extendedProps.id_patient_appointment}\n` +
                                `Doctor: ${info.event.extendedProps.id_doctor_appointment}`
                            );
                            
                            alert(`remove?id=${info.event.extendedProps.id}`);
                        }
                    }
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