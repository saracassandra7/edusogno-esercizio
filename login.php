<?php
  include "db_conn.php";

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
      
      if(empty($email)){
        $msg = "Inserisci la tua email";
        header("Location: index.php#$msg");
        exit();
      }
      else if(empty($password)) {
        $msg = "Inserisci la password";
        header("Location: index.php#$msg");
        exit();
      }
      
      $q = $conn->prepare("SELECT * FROM utenti WHERE email = :email");
      $q->bindParam(':email', $email); 
    
      //esecuzione
      $q->execute(); // eseguo la query

      $row = $q->fetch();

      //controllo dei dati inseriti
      if ($row) {
        if (password_verify($password, $row['password'])) {
        //Imposto la variabile di sessione con l'id dell'utente
        $_SESSION['id'] = $row['id'];

        //Reindirizzo l'utente alla sua pagina di profilo
        header('Location: home.php');

        }elseif($email != $row['email']){
          $msg = "Email non corretta";

          header("Location: index.php#$msg");

        }else{
          $msg = "Password non corretta";

          header("Location: index.php#$msg");
        }

      } else{
        // Messaggio da mostrare all'utente
        $msg= "Utente non trovato";
        
        header("Location: index.php#$msg");
        exit;
      }

    }
  }
?>