<?php

    function connection(){
        $connection = new mysqli("localhost", "root", "", "plexsalud");
        return $connection;
    }

    function listAllAppointmentPatient($idPatient){
        $connection = connection();

        $sql = "SELECT
                  a.id_appointment,
                  DATE_FORMAT(a.date_appointment, '%d/%m/%Y') AS date_fmt,
                  TIME_FORMAT(a.time_appointment, '%H:%i')     AS time_fmt,
                  a.status_appointment,
                  d.first_name_doctor,
                  d.last_name_doctor,
                  d.specialty_doctor
                FROM appointments AS a
                JOIN doctors AS d 
                  ON d.id_doctor = a.id_doctor_appointment
                WHERE a.id_patient_appointment = $idPatient
                ORDER BY a.date_appointment ASC, a.time_appointment ASC";

        $result = $connection->query($sql);

        return $result;
    }

    function listAllAppointmentDoctor($idDoctor) {
      $connection = connection();

      $sql = "SELECT 
                a.id_appointment,
                DATE_FORMAT(a.date_appointment, '%d/%m/%Y') AS date_fmt,
                TIME_FORMAT(a.time_appointment, '%H:%i')     AS time_fmt,
                a.status_appointment,
                p.first_name_patient,
                p.last_name_patient,
                p.age_patient,
                p.gender_patient,
                p.email_patient
              FROM appointments AS a
              JOIN patients AS p
                ON p.id_patient = a.id_patient_appointment
              WHERE a.id_doctor_appointment = $idDoctor
              ORDER BY a.date_appointment ASC, a.time_appointment ASC";

      $result = $connection->query($sql);

      return $result;
  }


    function addNewAppointmentForPatient($idPatient, $idDoctor, $date, $time, $status = 'Pendiente' ){
      $connection = connection();
      
      $sql = "INSERT INTO appointments (id_patient_appointment, id_doctor_appointment, date_appointment, time_appointment, status_appointment) VALUES('$idPatient', '$idDoctor', '$date', '$time', '$status')";
    
      $connection->query($sql);
    
    }

    function listAllDoctor(){
      $connection = connection();

      $sql = "SELECT id_doctor, first_name_doctor, last_name_doctor, specialty_doctor FROM doctors";

      $result = $connection->query($sql);

      return $result;
    }

      function updateAppointmentStatus($idAppointment, $status) {
        $connection = connection();

        // Validar estado permitido
        $allowed = ['Pendiente', 'Confirmada', 'Cancelada'];
        if (!in_array($status, $allowed)) {
            return false;
        }

        $stmt = $connection->prepare("UPDATE appointments SET status_appointment = ? WHERE id_appointment = ?");
        $stmt->bind_param('si', $status, $idAppointment);
        return $stmt->execute();
    }



    // function DameCitasPorDoctosEnEstaFecha($idDoctor, $fechaInicio, $fechaFinal){
    //     $sql = "SELECT * FROM appointments WHERE id_doctor = '$idDoctor' AND date_appointment BETWEEN('$fechaInicio', '$fechaFinal)";
    // }
   

?>