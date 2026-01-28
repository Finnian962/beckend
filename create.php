<?php
include('config/config.php');

$display = "none";

if (isset($_POST['submit'])) {

    // PDO verbinding
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Formulier opschonen
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // ✅ LET OP: kolomnamen EXACT zoals in de database
    $sql = "INSERT INTO HoogsteAchtbaanVanEuropa
            (Rollecoaster, AmusementPark, Country, TopSpeed, Height, YearOfConstruction)
            VALUES
            (:rollecoaster, :amusementPark, :country, :topSpeed, :height, :yearOfConstruction)";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':rollecoaster', $_POST['naamAchtbaan'], PDO::PARAM_STR);
    $statement->bindValue(':amusementPark', $_POST['naamPretpark'], PDO::PARAM_STR);
    $statement->bindValue(':country', $_POST['land'], PDO::PARAM_STR);
    $statement->bindValue(':topSpeed', $_POST['topsnelheid'], PDO::PARAM_INT);
    $statement->bindValue(':height', $_POST['hoogte'], PDO::PARAM_INT);
    $statement->bindValue(':yearOfConstruction', $_POST['bouwjaar'], PDO::PARAM_STR);

    $statement->execute();

    $display = "flex";
    header('Refresh:3; url=index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Achtbaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container mt-3">

    <div class="row justify-content-center" style="display:<?= $display; ?>">
        <div class="col-6">
            <div class="alert alert-success text-center">
                De gegevens zijn toegevoegd. U wordt doorgestuurd naar de index-pagina.
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <h3 class="text-primary mb-3">Nieuwe achtbaan toevoegen</h3>

            <form action="create.php" method="POST">
                <div class="mb-3">
                    <label>Naam achtbaan</label>
                    <input type="text" name="naamAchtbaan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Naam pretpark</label>
                    <input type="text" name="naamPretpark" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Land</label>
                    <input type="text" name="land" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Topsnelheid (km/u)</label>
                    <input type="number" name="topsnelheid" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Hoogte (m)</label>
                    <input type="number" name="hoogte" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Bouwjaar</label>
                    <input type="date" name="bouwjaar" class="form-control" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">
                    Opslaan
                </button>
            </form>

            <div class="mt-3">
                <a href="index.php">
                    <i class="bi bi-arrow-left-square-fill text-danger fs-4"></i> Terug
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
