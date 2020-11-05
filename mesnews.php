<head>
    <title>Mes news</title>
</head>

<body>
    <header>
        <a href="#" onclick="Annuler()"> Retour à l'accueil </a> </br>
    </header>

    <article>
        <?php
        include 'connexion.php';
        session_start();

        $mesnews = $objPdo->prepare("SELECT * FROM news WHERE idredacteur = :idredac");
        $mesnews->bindValue('idredac', $_SESSION['id'], PDO::PARAM_INT);
        $mesnews->execute();

        foreach ($mesnews as $row) {
            $_SESSION['idnews'] = $row['idnews'];

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
            echo  $theme . '<br>';

            echo '<h1>Titre :</h1>';
            echo $titre . '<br>';

            echo '<h1>News :</h1>';
            echo $contenu . '<br>';

            echo '<a href="modifier_news.php?idnews=' . $idnews . '&titre=' . $titre . '&contenu=' . $contenu . '"> Modifier </a> <br>';
            echo '<a href="supprimer_news.php?idnews=' . $idnews . '"> Supprimer </a> <br>';

            echo ' </br> </br>';
        }
        ?>
    </article>

    <script language="javascript" type="text/javascript">
        function Annuler() {
            if (confirm("Souhaitez-vous revenir à l'accueil ?"))
                window.location.href = "accueil.php"
        }
    </script>
</body>