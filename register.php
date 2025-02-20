<?php
require __DIR__ . "/partials/background.php";
include 'db_conn.php';
include 'partials/header.html';

$firstname = $lastname = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { 

  $firstname = test_input($_POST["firstname"]);
  $lastname = test_input($_POST["lastname"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $password = password_hash($password, PASSWORD_DEFAULT);

  //preparo la query
  $stmt = $conn->prepare("SELECT * FROM utenti WHERE email = :email");
  $stmt->execute(['email' => $email]);
  $control = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  //controllo che l'utente riempia tutti i campi
  if(empty($firstname)){
    $msg = "Il nome è un campo obbligatorio";
    header("Location: register.php#$msg");
    exit();
  }
  if(empty($lastname)){
    $msg = "Il cognome è un campo obbligatorio";
    header("Location: register.php#$msg");
    exit();
  }  if(empty($email)){
    $msg = "L'email è un campo obbligatorio";
    header("Location: register.php#$msg");
    exit();
  }  if(empty($password)){
    $msg = "La password è un campo obbligatorio";
    header("Location: register.php#$msg");
    exit();
  }


  //Controllo se l'email è già esistente
  if($stmt->rowCount() > 0){
    $msg = "Email già esistente";
    header("Location: register.php#$msg");
    exit;
  }else{
    //registro il nuovo utente
    $q = $conn->prepare("INSERT INTO utenti (nome, cognome, email, password) VALUES (:firstname, :lastname, :email, :password)");
  
    //binding
    $q->bindParam(':firstname', $firstname);
    $q->bindParam(':lastname', $lastname);
    $q->bindParam(':email', $email); 
    $q->bindParam(':password', $password); 
  
    //esecuzione
    $q->execute(); // eseguo la query

    //salvo l'ultimo id inserito in sessione
    $_SESSION['id'] = $conn->lastInsertId();
  
    header('Location: home.php');
  };

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
  <link rel="stylesheet" href="./assets/styles/general.css">
  <title>Edusogno</title>
</head>
<body>
  <div class="container">
  <div id="feedback-container" class="hidden"></div>
    <h1>Crea il tuo account</h1>
    <div class="form-container">
    <form action="register.php" method="post">
    <div>
      <label for="firstname">Inserisci il nome*</label>
      <input type="text" name="firstname" id="firstname">
    </div>

    <div>
      <label for="lastname">Inserisci il cognome*</label>
      <input type="text" name="lastname" id="lastname">
    </div>

    <div>
      <label for="email">Inserisci l'email*</label>
      <input type="email" name="email" id="email">
    </div>

    <div>
      <label for="password">Inserisci la password*</label>
      <input type="password" name="password" id="password">
    </div>

    <button type="submit">Registrati</button>
    <p>Hai già un account? <a href="index.php">Accedi</a></p>
    </form>
    </div>
  </div>
  
</body>

<script>
// Estraggo il messaggio dalla URL
let msg = decodeURIComponent(window.location.hash.substr(1));

// Se il messaggio di feedback esiste, lo visualizzo
if (msg) {
  // Creo un elemento HTML per il messaggio di feedback
  let feedback = document.createElement("div");
  feedback.classList.add("feedback-message");
  feedback.textContent = msg;

  // Aggiungo l'elemento HTML al documento
  let container = document.getElementById("feedback-container");
  container.appendChild(feedback);

  // Mostro il contenitore
  container.classList.remove("hidden");
}
</script>
</html>