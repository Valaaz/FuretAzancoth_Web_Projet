<?php
include '../connexion/connexion.php';

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

echo '<div class="datenews">' . 'Rédigé le ' . $date . ' par ' . $redacteur . '</div>';

echo '<h1 class="italic">Thème :</h1>';
echo $theme . '<br>';

echo '<h1 class="italic">Titre :</h1>';
echo $titre . '<br>';

echo '<h1 class="italic">News :</h1>';
echo '<textarea rows="10" cols="82" readonly>' . $contenu . '</textarea>' . '<br> <br>';

echo '<a class="modif" href="../news/modifier_news.php?idnews=' . $idnews . '&titre=' . $titre . '&contenu=' . $contenu . '"> Modifier </a>';
echo '<a class="supp" onclick="return confirm(\'Voulez-vous vraiment supprimer cette news ?\')" href="../news/supprimer_news.php?idnews=' . $idnews . '"> Supprimer </a> <br>';
