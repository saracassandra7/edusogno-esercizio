<?php

include "db_conn.php";

$token = $_GET['token'];

if (isset($_POST['password'])) {

  $password = $_POST['password'];
  $new_password = $_POST['new_password'];

  if ($password != $new_password) {
    echo 'errore'; die;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $q = $conn->prepare("UPDATE utenti SET password = :password, token = NULL WHERE token = :token");
  $q->bindParam(':password', $password); 
  $q->bindParam(':token', $token); 
  $q->execute();

  $msg = "Password reimpostata con successo!";

  header("Location: index.php#$msg");
}


$q = $conn->prepare("SELECT * FROM utenti WHERE token = :token");
$q->bindParam(':token', $token); 

//esecuzione
$q->execute(); // eseguo la query

$row = $q->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Nuova password</title>
</head>
<body>
  
<!-- <form action="" method="post">
  <input type="text" name="password" placeholder="nuova password">
  <input type="text" name="new_password" placeholder="re inserisci la nuova password">
  <input type="submit">
</form> -->

<div class="container">
  <h1 class="my-3">Richiesta di nuova password</h1>
  <form action="" method="post" class="row g-3">
  <div class="col-auto">
    <label for="password">Inserici la nuova password</label>
    <input type="password" name="password" class="form-control">
  </div>
  <div class="col-auto">
    <label for="new_password">Ripeti la nuova password</label>
    <input type="password" name="new_password" class="form-control">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary mb-3">Invia</button>
  </div>
</form>
</div>
</body>
</html>