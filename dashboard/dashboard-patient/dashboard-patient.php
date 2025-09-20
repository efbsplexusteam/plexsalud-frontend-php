<?php
    include("../../shared/includes/functions.php");

    if (isset($_POST['change_status'])) {
        $idAppointment = (int)$_POST['id_appointment'];
        $status = $_POST['status'];

        if (updateAppointmentStatus($idAppointment, $status)) {
            echo "<script>alert('Estado actualizado correctamente');</script>";
        } else {
            echo "<script>alert('Error al actualizar el estado');</script>";
        }
    }

    
    if (isset($_POST['add_appointment'])) {
        $idPatient = 1; // TEMPORAL para pruebas

        $date     = $_POST['date']     ?? null;
        $time     = $_POST['time']     ?? null;
        $idDoctor = $_POST['id_doctor'];
        $status   = 'Pendiente'; // al crear, lo fijamos por defecto

        addNewAppointmentForPatient($idPatient, $idDoctor, $date, $time, $status);

    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
<body>
  <?php include("../../shared/includes/header.php") ?>
  <div class="container p-5">
    <h2>Mis Citas Médicas</h2>
    <div class="d-flex justify-content-end mb-3">
      <div class="container-end">
        <button class="btn btn-outline-success" type="button"  data-bs-toggle="modal" data-bs-target="#modalNewAppointment">Añadir nueva cita</button>
      </div>
    </div>
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        <tr>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Médico</th>
          <th>Especialidad</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="appointments-table">
        <!-- TODO: Aquí se cargarán las citas-->
         <?php
          $appointments = listAllAppointmentPatient(1);
          foreach($appointments as $appointment){
        ?>
          <tr>
            <td><?=$appointment['date_fmt']?></td>
            <td><?=$appointment['time_fmt']?></td>
            <td><?=$appointment['first_name_doctor']." ".$appointment['last_name_doctor']?></td>
            <td><?=$appointment['specialty_doctor']?></td>
            <td><?=$appointment['status_appointment']?></td>
            <td>
              <form method="post" action="dashboard-patient.php">
                <input type="hidden" name="id_appointment" value="<?= $appointment['id_appointment'] ?>">
                <input type="hidden" name="status" value="Cancelada">
                <button type="submit" name="change_status" class="btn btn-sm btn-danger">Cancelar</button>
              </form>
            </td>
          </tr>

        <?php
          }
        ?>
      </tbody>
    </table>
    </div>

  <!-- Modal para añadir nueva cita -->
  <div class="modal fade" id="modalNewAppointment" tabindex="-1" aria-labelledby="modalNewAppointmentLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNewAppointmentLabel">Añadir Nueva Cita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="formNewDate" method="POST">
            <div class="mb-3">
              <label for="date" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
              <label for="time" class="form-label">Hora</label>
              <input type="time" class="form-control" name="time" id="time" required>
            </div>
            <div class="mb-3">
              <label for="doctor" class="form-label">Médico</label>
                <select class="form-select" id="doctor" name="id_doctor" required>
                  <option value="Medico" disabled>Medico (Especialidad)</option>
                  <?php
                    $doctors = listAllDoctor();
                    foreach($doctors as $doctor){
                  ?>
                      <option value="<?=$doctor['id_doctor']?>"><?=$doctor['first_name_doctor']." ".$doctor['last_name_doctor'] ?> (<?= $doctor['specialty_doctor']?>)</option>
                  <?php
                    }
                  ?>
                </select>
            </div>
            <button type="submit" name="add_appointment" class="btn btn-success">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
