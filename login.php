<?php
  include "db_conn.php";
  // include "register.php";

  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifico se il token CSRF inviato dal form corrisponde a quello salvato nella sessione
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
      die("CSRF validation failed");
    }

    // Validazione dati
    if(isset($_POST['email']) && isset($_POST['password'])){

      $email = validate($_POST['email']);
      $password = validate($_POST['password']);

      $q = $conn->prepare("SELECT * FROM utenti WHERE email = :email");
      $q->bindParam(':email', $email); 
      // $q->bindParam(':password', $password); 
    
      //esecuzione
      $q->execute(); // eseguo la query

      $row = $q->fetch();

      if ($row) {
        if (password_verify($password, $row['password'])) {
        //Imposto la variabile di sessione con l'id dell'utente
        $_SESSION['id'] = $row['id'];

        //Reindirizzo l'utente alla sua pagina di profilo
        header('Location: home.php');
        }
      }

      echo 'utente non trovato'; die;

      // var_dump($row); die;

      if(empty($username)){
        header("Location: index.php?error=Username is required");
        exit();
      }
      else if(empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
      }
    }
  }
?>