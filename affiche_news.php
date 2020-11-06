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

echo '<div class="date">' . 'Rédigé le ' . $date . '</div>';

echo '<div class="theme">' . '<h1>Thème :</h1>' . '</div>';
echo  $theme . '<br>';

echo '<div class="titre">' . '<h1>Titre :</h1>' . '</div>';
echo $titre . '<br>';

echo '<div class="contenu">' . '<h1>News :</h1>' . '</div>';
echo '<textarea rows="10" cols="82">' . $contenu . '</textarea>' . '<br> <br>';

echo '<div class="redac">' . $redacteur . '</div>';
