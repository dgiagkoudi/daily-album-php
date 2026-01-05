<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$json = file_get_contents("albums.json");
$albums = json_decode($json, true);

if (!$albums || !is_array($albums)) {
    die("Σφάλμα φόρτωσης δεδομένων.");
}

srand(date("Ymd"));

$index = rand(0, count($albums) - 1);
$albumOfTheDay = $albums[$index];

$thankYouMessage = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artist = trim($_POST["artist"] ?? "");
    $album  = trim($_POST["album"] ?? "");
    $year   = trim($_POST["year"] ?? "");

    if ($artist !== "" && $album !== "") {
        $newSuggestion = [
            "artist" => $artist,
            "album"  => $album,
            "year"   => $year,
            "date"   => date("Y-m-d")
        ];

        $file = "suggestions.json";
        $data = json_decode(file_get_contents($file), true) ?? [];

        $data[] = $newSuggestion;

        file_put_contents(
            $file,
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        $thankYouMessage = true;
    }
}
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
    <section class="daily-album">
        <div class="container">
            <h1>Δίσκος της Ημέρας</h1>

            <img src="<?= $albumOfTheDay['cover'] ?>" alt="Album cover">

            <h2><?= htmlspecialchars($albumOfTheDay['album']) ?></h2>
            <p class="artist"><?= htmlspecialchars($albumOfTheDay['artist']) ?></p>
            <p class="year"><?= $albumOfTheDay['year'] ?></p>

            <p class="date"><?= date("d / m / Y") ?></p>
        </div>
    </section>

    <section class="suggestions">
        <h2>Πρότεινε έναν δίσκο</h2>

        <?php if ($thankYouMessage): ?>
            <p class="thank-you">Thank you!</p>
        <?php endif; ?>

        <form method="post" class="suggestion-form">
            <input type="text" name="artist" placeholder="Καλλιτέχνης" required>
            <input type="text" name="album" placeholder="Άλμπουμ" required>
            <input type="number" name="year" placeholder="Έτος (προαιρετικό)">
            <button type="submit">Υποβολή</button>
        </form>
    </section>
</body>
</html>