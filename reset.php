<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "db_conn.php";

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);

  $q = $conn->prepare("SELECT * FROM utenti WHERE email = :email");
  $q->bindParam(':email', $email); 

  //esecuzione
  $q->execute(); // eseguo la query

  $row = $q->fetch();

  if ($row) {
    // genero il token
    $token = md5(uniqid());
    // salvo il token nel record dell'utente
    $stmt = $conn->prepare("UPDATE utenti SET token = :token WHERE email = :email");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // invio la mail
    
    //autoload the PHPMailer
    require("vendor/autoload.php");

    // Recupero l'indirizzo email inserito dall'utente
    $to = $_POST["email"];

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'fd0d3a2a9757f9';
    $mail->Password = '0e48ff8c1f5cc4';
    $mail->Port = 2525;
    $mail->IsHTML(true);
   
    $mail->setFrom('edusognoesercizio@mail.com', 'Sara');
    $mail->addAddress($to, 'Utente');
    $mail->Subject = 'Richiesta di reset password';
    $mail->Body = "Se hai richiesto di resettare la password clicca <a href='http://localhost/edusogno-esercizio/new_password.php?token=" . "$token'".">questo link</a>" ;

    if(!$mail->send()) {
      echo 'Errore: ' . $mail->ErrorInfo;
    } else {
      echo 'Email inviata con successo!';
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Reset Password</title>
</head>
<body>
  <div class="container">
  <h1 class=" my-3">Reset password</h1>
<form action="" method="post" class="row g-3">
  <div class="col-auto">
    <label for="email">Inserici la tua mail</label>
    <input type="email" name="email" class="form-control" placeholder="email@example.com">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary mb-3">Invia</button>
  </div>
</form>
</div>
</body>
</html>