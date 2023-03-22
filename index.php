<?php
  include 'partials/header.html';
  session_start();

  $token = bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $token;
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
  <h1>Hai già un account?</h1>
  <div class="form-container">
  <form action="login.php" method="POST">
        <!-- token csrf -->
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

        <?php if(isset($_GET['error'])) { ?>
          <p class="error"> <?php echo $_GET['error']; ?> </p>
        <?php } ?>

        <label for="email">Email</label>
        <input type="text" name="email" placeholder="inserisci la tua email" value="email@email.email"> <br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="inserisci la password" value="password"> <br>

        <button type="submit">Login</button> <br>

        <p>Non hai ancora un profilo? <a href="register.php">Registrati</a></p>

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