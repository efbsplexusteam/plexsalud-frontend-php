<?php
  require __DIR__ . '/db.php'; // conexión mysqli
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id     = (int)($_POST['id_appointment'] ?? 0);
      $status = $_POST['status'] ?? '';

      $allowed = ['Pendiente', 'Confirmada', 'Cancelada'];
      if ($id > 0 && in_array($status, $allowed, true)) {
          $stmt = $conn->prepare("UPDATE appointments SET status_appointment = ? WHERE id_appointment = ?");
          $stmt->bind_param('si', $status, $id);
          $stmt->execute();
      }
  }

  // Redirige de vuelta a la página anterior
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
?>