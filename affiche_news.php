<?php
include 'connexion.php';
$query = $objPdo->prepare("SELECT * FROM news WHERE idnews = :idnews");
$query->bindValue(':idnews', $_SESSION['idnews'], PDO::PARAM_INT);
$query->execute();

// Partie theme
$querytheme = $objPdo->prepare("SELECT idtheme FROM news WHERE idnews = :idnews");
$querytheme->bindValue(':idnews', $_SESSION['idnews'], PDO::PARAM_INT);
$idtheme = $querytheme->execute();

$resulttheme = $objPdo->prepare("SELECT description FROM theme WHERE idtheme = :idtheme");
$resulttheme->bindvalue(':idtheme', $idtheme, PDO::PARAM_INT);
$resulttheme->execute();
while ($row2 = $resulttheme->fetch())
    $theme = $row2['description'];

// Partie redacteur
/*
$queryredac = $objPdo->query("SELECT idredacteur FROM news WHERE idnews = 1");
$idredacteur = $queryredac->execute();

$resultredac = $objPdo->prepare("SELECT pseudo FROM redacteur WHERE idredacteur = :idredacteur");
$resultredac->bindvalue(':idredacteur', $idredacteur, PDO::PARAM_INT);
$resultredac->execute();
while ($row3 = $resultredac->fetch())
    $redacteur = $row3['pseudo'];
    */
?>

<body>
    <article>
        <?php
        while ($row = $query->fetch()) {
            echo 'Rédigé le ' . $row['datenews'] . ' par ';

            echo '<h1>Thème :</h1>';
            echo  $theme . '<br>';

            echo '<h1>Titre :</h1>';
            echo $row['titrenews'] . '<br>';

            echo '<h1>News :</h1>';
            echo $row['textenews'] . '<br>';
        }
        ?>
    </article>
</body>