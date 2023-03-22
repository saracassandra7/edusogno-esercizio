<?php

include "db_conn.php";
include 'partials/header.html';

//recupero dati dell'utente loggato
$id = $_SESSION["id"];

$query = $conn->prepare("SELECT * FROM utenti WHERE id = :id");
$query->bindParam(':id', $id);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
// echo $row['nome'] . ' ' . $row['cognome'] .  '<br><br>' . $row['id']. '<br>';

//recupero dati dalla tabella eventi
// $email = $row['email'];
// $stmt = $conn->query("SELECT * FROM eventi WHERE attendees LIKE '%{$email}%' ");
// $event_row = $stmt->fetch(PDO::FETCH_ASSOC);

// while ($event_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// echo "Partecipanti: " . $event_row["attendees"] . "<br>";
// echo "Evento: " . $event_row["nome_evento"] . "<br>";
// echo "Data: " . $event_row["data_evento"] . "<br>";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/styles/general.css">
  <link rel="stylesheet" href="./assets/styles/profile_styles.css">
  <title>Edusogno</title>
</head>
<body>
  <div class="container">

    <h1 class="welcome-title">Ciao <?php echo $row['nome'] . ' ' . $row['cognome'] ?>, ecco i tuoi eventi</h1>

    <div class="event-container">
    <?php
      //recupero dati dalla tabella eventi
			$email = $row['email'];
			$stmt = $conn->query("SELECT * FROM eventi WHERE attendees LIKE '%{$email}%' ");

      while ($event_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<div class='card'>" 
          . '<h2 class="event-name">'. $event_row['nome_evento'] . '</h2>' 
          .'<p>'. $event_row['data_evento'] . '</p>' 
          . '<div class="btn"><span>JOIN</span></div>' .
        "</div>";
			}
		?>
    </div>

    <div class="logout-container">
    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
    </div>
  </div>
  
</body>
</html>