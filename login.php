<?php
  session_start();
  include "db_conn.php";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifico se il token CSRF inviato dal form corrisponde a quello salvato nella sessione
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
      die("CSRF validation failed");
    }

    // Validazione dati
    if(isset($_POST['username']) && isset($_POST['password'])){
      function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    }

    $username = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if(empty($username)){
      header("Location: index.php?error=Username is required");
      exit();
    }
    else if(empty($password)) {
      header("Location: index.php?error=Password is required");
      exit();
    }
  }
?>