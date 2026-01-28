<?php
include('config/config.php');

// PDO verbinding
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
$pdo = new PDO($dsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SQL query – gebruik exact de kolomnamen uit je database
$sql = "SELECT 
    ID,
    Rollecoaster,
    AmusementPark,
    country,
    TopSpeed,
    Height,
    DATE_FORMAT(YearOFConstruction, '%d-%m-%Y') AS YOFC
FROM HoogsteAchtbaanVanEuropa
ORDER BY Height DESC";

$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoogste Achtbanen van Europa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container mt-4">
    <h3 class="mb-3 text-center"><u>Hoogste achtbanen van Europa</u></h3>

    <div class="mb-3 text-center">
        <a href="create.php" class="btn btn-success">
            <i class="bi bi-plus-square"></i> Nieuwe achtbaan
        </a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Naam achtbaan</th>
                <th>Naam pretpark</th>
                <th>Land</th>
                <th class="text-center">Topsnelheid (km/u)</th>
                <th class="text-center">Hoogte (m)</th>
                <th>Bouwjaar</th>
                <th>wijzig</th>
                <th class="text-center">Verwijder</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $rollercoaster): ?>
            <tr>
                <td><?= htmlspecialchars($rollercoaster->Rollecoaster) ?></td>
                <td><?= htmlspecialchars($rollercoaster->AmusementPark) ?></td>
                <td><?= htmlspecialchars($rollercoaster->country) ?></td>
                <td class="text-center"><?= $rollercoaster->TopSpeed ?></td>
                <td class="text-center"><?= $rollercoaster->Height ?></td>
                <td><?= $rollercoaster->YOFC ?></td>
                <td class = "text-center" >
                  <a href="update.php?id=<?= $rollercoaster->ID;?>">
                    <i class = "bi bi-pencil-sqaure text-success"></i>
              </a>
            </td>



                <td class="text-center">
                    <a href="delete.php?id=<?= $rollercoaster->ID ?>" class="text-danger">
                        <i class="bi bi-x-square"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

