<?php
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
    <h2>LOGIN</h2>
    <form action="login.php" method="post">
        <!-- token csrf -->
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

        <?php if(isset($_GET['error'])) { ?>
          <p class="error"> <?php echo $_GET['error']; ?> </p>
        <?php } ?>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="inserisci il tuo Username"> <br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="inserisci la password"> <br>

        <button type="submit">Login</button>

    </form>


</body>

</html>