<?php
include('config/config.php');

$display = "none";

if (isset($_POST["submit"])) {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "INSERT INTO HoogsteAchtbaanVanEuropa
            (RollerCoaster, AmusementPark, Country, TopSpeed, Height, YearOfConstruction)
            VALUES
            (:rollerCoaster, :amusementPark, :country, :topSpeed, :height, :yearOfConstruction)";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':rollerCoaster', $_POST['naamAchtbaan'], PDO::PARAM_STR);
    $statement->bindValue(':amusementPark', $_POST['naamPretpark'], PDO::PARAM_STR);
    $statement->bindValue(':country', $_POST['land'], PDO::PARAM_STR);
    $statement->bindValue(':topSpeed', $_POST['topsnelheid'], PDO::PARAM_INT);
    $statement->bindValue(':height', $_POST['hoogte'], PDO::PARAM_INT);
    $statement->bindValue(':yearOfConstruction', $_POST['bouwjaar'], PDO::PARAM_STR);

    $statement->execute();
    $display = "flex";

    header('Refresh:3; url=index.php');
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Achtbaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container mt-3">
    <div class="row justify-content-center" style="display:<?= $display; ?>">
        <div class="col-6">
            <div class="alert alert-success text-center">
                De gegevens zijn toegevoegd. U wordt teruggestuurd naar de index-pagina.
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <h3 class="text-primary mb-3">Voer een nieuwe achtbaan in:</h3>
            <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="inputNaamAchtbaan">Naam Achtbaan:</label>
                    <input type="text" name="naamAchtbaan" class="form-control" id="inputNaamAchtbaan" value="<?= $_POST['naamAchtbaan'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputNaamPretpark">Naam Pretpark:</label>
                    <input type="text" name="naamPretpark" class="form-control" id="inputNaamPretpark" value="<?= $_POST['naamPretpark'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputLand">Land:</label>
                    <input type="text" name="land" class="form-control" id="inputLand" value="<?= $_POST['land'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputTopsnelheid">Topsnelheid (km/u):</label>
                    <input type="number" name="topsnelheid" min="0" max="500" class="form-control" id="inputTopsnelheid" value="<?= $_POST['topsnelheid'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputHoogte">Hoogte (m):</label>
                    <input type="number" name="hoogte" min="0" max="500" class="form-control" id="inputHoogte" value="<?= $_POST['hoogte'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="inputBouwjaar">Bouwjaar:</label>
                    <input type="date" name="bouwjaar" class="form-control" id="inputBouwjaar" value="<?= $_POST['bouwjaar'] ?? '' ?>" required>
                </div>
                <button name="submit" type="submit" class="btn btn-primary btn-lg w-100">Verstuur</button>
            </form>
            <div class="mt-3">
                <a href="index.php"><i class="bi bi-arrow-left-square-fill text-danger" style="font-size:1.5em"></i> Terug</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
