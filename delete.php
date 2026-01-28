<?php
include('config/config.php');

// Maak verbinding met de database via PDO
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

// Controleer of er een geldige ID is meegegeven via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    // Prepareer de DELETE query
    $sql = "DELETE FROM HoogsteAchtbaanVanEuropa WHERE ID = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    // Voer de query uit
    $statement->execute();

    // Redirect na 3 seconden terug naar index.php
    header('refresh:3; url=index.php');

} else {
    // Geen geldige ID, direct terug naar index.php
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Achtbaan verwijderen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="alert alert-success text-center" role="alert">
        De achtbaan is succesvol verwijderd. U wordt teruggestuurd naar de overzichtspagina.
      </div>
    </div>
  </div>
</div>
</body>
</html>
