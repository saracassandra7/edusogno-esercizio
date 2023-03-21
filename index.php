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
    <link rel="stylesheet" href="./assets/styles/style.css">
    <title>Edusogno</title>
</head>

<body>
  <div class="container">
  <h1>Hai già un account?</h1>
  <div class="form-container">
  <form action="login.php" method="POST">
        <!-- token csrf -->
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

        <?php if(isset($_GET['error'])) { ?>
          <p class="error"> <?php echo $_GET['error']; ?> </p>
        <?php } ?>

        <label for="username">Username</label>
        <input type="text" name="email" placeholder="inserisci il tuo Username" value="email@email.email"> <br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="inserisci la password" value="password"> <br>

        <button type="submit">Login</button> <br>

        <p>Non hai un account? Registrati <a href="register.php">qui</a> </p>

    </form>
  </div>
  </div>


</body>

</html>