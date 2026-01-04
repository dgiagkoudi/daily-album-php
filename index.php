<?php
$json = file_get_contents("albums.json");
$albums = json_decode($json, true);

if (!$albums || !is_array($albums)) {
    die("Σφάλμα φόρτωσης δεδομένων.");
}

srand(date("Ymd"));

$index = rand(0, count($albums) - 1);
$albumOfTheDay = $albums[$index];
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Δίσκος της Ημέρας</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>

<div class="container">
    <h1>Δίσκος της Ημέρας</h1>

    <img src="<?= $albumOfTheDay['cover'] ?>" alt="Album cover">

    <h2><?= htmlspecialchars($albumOfTheDay['album']) ?></h2>
    <p class="artist"><?= htmlspecialchars($albumOfTheDay['artist']) ?></p>
    <p class="year"><?= $albumOfTheDay['year'] ?></p>

    <p class="date"><?= date("d / m / Y") ?></p>
</div>

</body>
</html>