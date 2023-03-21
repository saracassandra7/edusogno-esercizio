<?php
include 'db_conn.php';
include 'partials/header.html';

$firstname = $lastname = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 

  $firstname = test_input($_POST["firstname"]);
  $lastname = test_input($_POST["lastname"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $password = password_hash($password, PASSWORD_DEFAULT);

  //Preparazione query
  $q = $conn->prepare("INSERT INTO utenti (nome, cognome, email, password) VALUES (:firstname, :lastname, :email, :password)");

  //binding
  $q->bindParam(':firstname', $firstname);
  $q->bindParam(':lastname', $lastname);
  $q->bindParam(':email', $email); 
  $q->bindParam(':password', $password); 

  //esecuzione
  $q->execute(); // eseguo la query

  // header('Location: home.php');
  header('Location: index.php');
}

function test_input($data) {

  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/styles/style.css">
  <title>Edusogno</title>
</head>
<body>
  <div class="container">
    <h1>Crea il tuo account</h1>
    <div class="form-container">
    <form action="register.php" method="post">
    <div>
      <label for="firstname">Nome</label>
      <input type="text" name="firstname" id="firstname" value="nome">
    </div>

    <div>
      <label for="lastname">Cognome</label>
      <input type="text" name="lastname" id="lastname" value="cognome">
    </div>

    <div>
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="email@email.email">
    </div>

    <div>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="password">
    </div>

    <button type="submit">Register</button>
    <p>Hai già un account? Accedi <a href="index.php">qui</a></p>
    </form>
    </div>
  </div>
  
</body>
</html>