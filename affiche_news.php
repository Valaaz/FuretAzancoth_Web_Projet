<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="css/affiche_news.css" />
</head>

<?php
include 'connexion.php';

$idnews = $_SESSION['idnews'];

$query = $objPdo->prepare("SELECT * FROM news WHERE idnews = :idnews");
$query->bindValue(':idnews', $idnews, PDO::PARAM_INT);
$query->execute();
while ($row = $query->fetch()) {
    $theme = $row['idtheme'];
    $titre = $row['titrenews'];
    $contenu = $row['textenews'];
    $date = $row['datenews'];
    $idredacteur = $row['idredacteur'];
}

// Partie theme
$resulttheme = $objPdo->prepare("SELECT description FROM theme WHERE idtheme = :idtheme");
$resulttheme->bindvalue(':idtheme', $theme, PDO::PARAM_INT);
$resulttheme->execute();
while ($row2 = $resulttheme->fetch())
    $theme = $row2['description'];

// Partie redacteur
$resultredac = $objPdo->prepare("SELECT pseudo FROM redacteur WHERE idredacteur = :idredacteur");
$resultredac->bindvalue(':idredacteur', $idredacteur, PDO::PARAM_INT);
$resultredac->execute();
while ($row3 = $resultredac->fetch())
    $redacteur = $row3['pseudo'];

echo 'Rédigé le ' . $date . ' par ' . $redacteur;

echo '<h1>Thème :</h1>';
echo  '<div class="titre">' . $theme . '</div>' . '<br>';

echo '<h1>Titre :</h1>';
echo $titre . '<br>';

echo '<h1>News :</h1>';
echo $contenu . '<br>';
?>
</body>