<?php
include('config/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";

$pdo = new PDO($dsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$display = 'none';

if (isset($_POST['submit'])) {

    // formulier verzonden
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "UPDATE HoogsteAchtbaanVanEuropa SET 
                RollerCoaster = :RollerCoaster,
                AmusementPark = :AmusementPark,
                Country = :Country,
                TopSpeed = :TopSpeed,
                Height = :Height,
                YearOfConstruction = :YearOfConstruction
            WHERE ID = :id";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':RollerCoaster', $_POST['naamAchtbaan'], PDO::PARAM_STR);
    $statement->bindValue(':AmusementPark', $_POST['naamPretpark'], PDO::PARAM_STR);
    $statement->bindValue(':Country', $_POST['land'], PDO::PARAM_STR);
    $statement->bindValue(':TopSpeed', $_POST['topsnelheid'], PDO::PARAM_INT);
    $statement->bindValue(':Height', $_POST['hoogte'], PDO::PARAM_INT);
    $statement->bindValue(':YearOfConstruction', $_POST['bouwjaar'], PDO::PARAM_STR);
    $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);

    $statement->execute();

    $display = 'flex';
    header('Refresh:3; url=index.php');
    exit;

} else {

    // pagina geopend via wijzig-knop
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php');
        exit;
    }

    $sql = "SELECT 
                ID,
                RollerCoaster,
                AmusementPark,
                Country,
                TopSpeed,
                Height,
                YearOfConstruction
            FROM HoogsteAchtbaanVanEuropa
            WHERE ID = :id";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_OBJ);
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-6">
            <h3 class="text-primary">Wijzig de achtbaangegevens</h3>
        </div>
    </div>

    <div class="row justify-content-center" style="display:<?=$display?>;">
        <div class="col-6">
            <div class="alert alert-success text-center" role="alert">
                De gegevens zijn gewijzigd. U wordt doorgestuurd naar de index-pagina.
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <form action="update.php" method="POST">
                <div class="mb-3">
                    <label for="inputNaamAchtbaan" class="form-label">Naam Achtbaan:</label>
                    <input type="text" class="form-control" id="inputNaamAchtbaan" name="naamAchtbaan"
                           value="<?=$result->RollerCoaster ?? $_POST['naamAchtbaan']?>">
                </div>
                <div class="mb-3">
                    <label for="inputNaamPretpark" class="form-label">Naam Pretpark:</label>
                    <input type="text" class="form-control" id="inputNaamPretpark" name="naamPretpark"
                           value="<?=$result->AmusementPark ?? $_POST['naamPretpark']?>">
                </div>
                <div class="mb-3">
                    <label for="inputLand" class="form-label">Land:</label>
                    <input type="text" class="form-control" id="inputLand" name="land"
                           value="<?=$result->Country ?? $_POST['land']?>">
                </div>
                <div class="mb-3">
                    <label for="inputTopsnelheid" class="form-label">Topsnelheid:</label>
                    <input type="number" min="0" max="500" class="form-control" id="inputTopsnelheid" name="topsnelheid"
                           value="<?=$result->TopSpeed ?? $_POST['topsnelheid']?>">
                </div>
                <div class="mb-3">
                    <label for="inputHoogte" class="form-label">Hoogte:</label>
                    <input type="number" min="0" max="255" class="form-control" id="inputHoogte" name="hoogte"
                           value="<?=$result->Height ?? $_POST['hoogte']?>">
                </div>
                <div class="mb-3">
                    <label for="inputBouwjaar" class="form-label">Bouwjaar:</label>
                    <input type="date" class="form-control" id="inputBouwjaar" name="bouwjaar"
                           value="<?=$result->YearOfConstruction ?? $_POST['bouwjaar']?>">
                </div>

                <input type="hidden" name="id" value="<?=$result->ID ?? $_POST['id']?>">

                <div class="d-grid gap-2">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg mt-2">Verstuur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
