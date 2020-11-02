<body>
    <article>
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
        }

        // Partie theme
        /*
        $querytheme = $objPdo->prepare("SELECT idtheme FROM news WHERE idnews = :idnews");
        $querytheme->bindValue(':idnews', $idnews, PDO::PARAM_INT);
        $idtheme = $querytheme->execute();
        echo '<br> 2 : Theme en cours : ' . $idtheme;
        */

        $resulttheme = $objPdo->prepare("SELECT description FROM theme WHERE idtheme = :idtheme");
        $resulttheme->bindvalue(':idtheme', $theme, PDO::PARAM_INT);
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
        echo 'Rédigé le ' . $date . ' par ';

        echo '<h1>Thème :</h1>';
        echo  $theme . '<br>';

        echo '<h1>Titre :</h1>';
        echo $titre . '<br>';

        echo '<h1>News :</h1>';
        echo $contenu . '<br>';
        ?>
    </article>
</body>