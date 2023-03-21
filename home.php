<?php

include "db_conn.php";
include 'partials/header.html';

// // Recupero l'id dell'utente loggato
// $id = $_SESSION['id'];

// // Eseguo la query per recuperare i dati dell'utente loggato
// $query = $conn->prepare("SELECT * FROM utenti WHERE id = :id");
// $query->execute([':id' => $id]);
// $row = $query->fetch(PDO::FETCH_ASSOC);

// echo $row['nome'] . $row['cognome'] .  '<br><br>';


// // Eseguo la query per recuperare i dati dalla tabella eventi
// $stmt = $conn->query("SELECT * FROM eventi");

// while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   echo "Partecipanti: " . $row2["attendees"] . "<br>";
//   echo "Evento: " . $row2["nome_evento"] . "<br>";
//   echo "Data: " . $row2["data_evento"] . "<br>";
// }

// $conn = null;

//recupero dati dell'utente loggato
$id = $_SESSION["id"];

$query = $conn->prepare("SELECT * FROM utenti WHERE id = :id");
$query->bindParam(':id', $id);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
echo $row['nome'] . ' ' . $row['cognome'] .  '<br><br>' . $row['id']. '<br>';

//recupero dati dalla tabella eventi
$email = $row['email'];
$stmt = $conn->query("SELECT * FROM eventi WHERE attendees LIKE '%{$email}%' ");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo "Partecipanti: " . $row["attendees"] . "<br>";
echo "Evento: " . $row["nome_evento"] . "<br>";
echo "Data: " . $row["data_evento"] . "<br>";
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
  
</body>
</html>