<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Score Foot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header class="header">
    <h1>Score foot</h1>
</header>
<?php
// Spécifie le chemin pour la classe apiCall.php
require_once 'apiCall.php';

// Instanciation de la classe apiCall afin de pouvoir utiliser sa méthode get
$apiCall = new apiCall();

// Tableau contenant tous les pays que tu souhaites être valides
// p.ex. si quelqu'un mets le paramètre ?pays=USA dans l'URL, une erreur sera retournée vu qu'il est pas dans le tableau
$countries = ['italy', 'france', 'germany'];

//Récupère le pays recherché
$searchedCountry = $_GET['pays'] ?? '';

// Vérifie que le pays est un pays valide
if (in_array(strtolower($searchedCountry), $countries)) {
    // Tableau qui contiendra toutes les leagues du pays
    $leagues = [];
    // Url pour récupérer toutes les leagues du pays
    $countryLeaguesUrl = "https://www.thesportsdb.com/api/v1/json/3/search_all_leagues.php?s=Soccer&c=" . $searchedCountry;

    // Récupération de toutes les leagues du pays
    $leagues = array_merge($leagues, $apiCall->get($countryLeaguesUrl)['countries']);

    // Tableau qui contiendra les matchs à afficher
    $matches = [];

    // On récupère les matchs pour chaque league
    foreach ($leagues as $league) {
        // Url pour récupérer les matchs par league et par saison
        $eventsUrl = 'https://www.thesportsdb.com/api/v1/json/3/eventsseason.php?id='.$league['idLeague'].'&s=2023-2024';

        // Récupération de tous les matchs pour chaque league
        $matches = array_merge($matches, $apiCall->get($eventsUrl)['events'] ?? []);
    }
?>

<table class="table table-info table-striped">
    <?php
    // Pour chaque match, une ligne de tableau est crée
        foreach ($matches as $match) {
            ?>
            <tr>
                <td><?= $match['dateEvent'] ?></td>
                <td>
                    <?= $match['strHomeTeam'] ?> <b> <?= $match['intHomeScore'] ?> - <?= $match['intAwayScore'] ?> </b>
                    <?= $match['strAwayTeam'] ?>
                </td>
                <td><?= $match['strVenue'] ?></td>
            </tr>
            <?php
        }
    } else {
    // Si aucun pays n'est spécifié dans l'URL ou que le pays ne fait pas partie du tableau $countries, le message s'affiche
    echo "Le pays spécifié n'existe pas";
    }
    ?>
</table>
</body>
</html>
