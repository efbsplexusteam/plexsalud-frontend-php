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
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>
<body>
    <?php include("../../shared/includes/header.php") ?>
    <div class="container p-5">
        <h2>Mi Agenda</h2>
        <table class="table table-bordered table-hover text-center">
        <thead class="table-light">
            <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Género</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="appointments-table">

            <?php
            
            $result = listAllAppointmentDoctor(1);
            foreach($result as $row){
            ?>
            <tr>
                <td><?=$row['date_fmt']?></td>
                <td><?=$row['time_fmt']?></td>
                <td><?=$row['first_name_patient']." ".$row['last_name_patient']?></td>        
                <td><?=$row['age_patient']?></td>
                <td><?=$row['gender_patient']?></td>
                <td><?=$row['email_patient']?></td>
                <td><?=$row['status_appointment']?></td>
                <td>
                    <form method="post" action="dashboard-doctor.php">
                        <input type="hidden" name="id_appointment" value="<?= $row['id_appointment'] ?>">
                        <input type="hidden" name="status" value="Confirmada">
                        <button type="submit" name="change_status" class="btn btn-sm btn-success">Confirmar</button>
                    </form>
                    <form method="post" action="dashboard-doctor.php">
                        <input type="hidden" name="id_appointment" value="<?= $row['id_appointment'] ?>">
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
</body>
</html>
