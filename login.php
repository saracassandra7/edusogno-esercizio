<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
      die("CSRF validation failed");
    }
    // gestire l'invio del form
  }
?>