<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/accueil.css" />
</head>

<body>
    <header>
        <h1>Accueil</h1>
        <div class="liens">
            <?php
            include '../connexion/connexion.php';
            session_start();

            $co = array();
            $re = array();
            if (isset($_SESSION['isLogged'])) {
                $co = '<a class="gauche" id="deco" href="#" onclick="MessageAlerte()"> Se deconnecter </a> <br>';
                echo $co;
                echo '<a class="droite" id="redac" href="../news/redaction.php"> Redacteur </a> <br>';
                echo '<a class="droite" href="./mesnews.php"> Mes news </a>';
                // Affichage des infos de l'utilisateur connecté
                echo '<div class="identite">';
                echo 'Connecté : ' . $_SESSION['pseudo'] . '<br>';
                echo $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '<br>';
                echo 'Mail : ' . $_SESSION['mail'];
                echo '</div>';
            } else if (isset($_SESSION['isLogged']) == false) {
                $co = '<a class="gauche" id="co" href="../connexion/identification.php"> Se connecter </a> <br>';
                echo '<a class="droite" href="../connexion/creercompte.php"> Creer un compte </a> <br>';
                echo $co;
            }
            ?>
        </div>
    </header>

    <hr>

    <form method="POST">
        <label class="tri">Trier par thème</label> </br>
        <select name="themetri">
            <option value='0'>Tous les thèmes</option>

            <?php
            $query = $objPdo->prepare("SELECT * FROM theme");
            $query->execute();
            foreach ($query as $row) {
                echo '<option value="' . $row['idtheme'] . '"';
                //Permet de garder le nom du thème sélectionné après le rafraichissment de la page
                if (isset($_POST['themetri']) && $_POST['themetri'] == $row['idtheme']) echo 'selected="selected"';
                echo ">" . $row['description'] . '</option>';
            }
            ?>
        </select> </br> </br>

        <label class="tri">Trier par date</label> </br>
        <select name="datetri">
            <option value='0'>Toutes les dates</option>

            <?php
            $query = $objPdo->prepare("SELECT DISTINCT date(datenews) FROM news");
            $query->execute();
            foreach ($query as $row) {
                echo '<option value="' . $row['date(datenews)'] . '"';
                //Permet de garder le nom du thème sélectionné après le rafraichissment de la page
                if (isset($_POST['datetri']) && $_POST['datetri'] == $row['date(datenews)']) echo 'selected="selected"';
                echo ">" . $row['date(datenews)'] . '</option>';
            }
            ?>
        </select> </br> </br>

        <input type="submit" value="Valider" name="valider"> <br /></br>
        <section>
            <?php
            if (isset($_POST['valider'])) {
                if ($_POST['themetri'] == 0 && $_POST['datetri'] == 0) {
                    $maxnews = $objPdo->prepare("SELECT * FROM news");
                    $maxnews->execute();

                    foreach ($maxnews as $row) {
                        $_SESSION['idnews'] = $row['idnews'];
                        echo '<article>';
                        include './affiche_news.php';
                        echo '</article>' . '</br> </br>';
                    }
                } else {
                    if ($_POST['themetri'] == 0 && $_POST['datetri'] != 0) {
                        $news = $objPdo->prepare("SELECT * FROM news WHERE datenews = :datetri");
                        $news->bindValue(':datetri', $_POST['datetri'], PDO::PARAM_STR);
                        $news->execute();
                    } else if ($_POST['datetri'] == 0 && $_POST['themetri'] != 0) {
                        $news = $objPdo->prepare("SELECT * FROM news WHERE idtheme = :themetri");
                        $news->bindValue(':themetri', $_POST['themetri'], PDO::PARAM_INT);
                        $news->execute();
                    } else {
                        $news = $objPdo->prepare("SELECT * FROM news WHERE idtheme = :themetri AND datenews = :datetri");
                        $news->bindValue(':themetri', $_POST['themetri'], PDO::PARAM_INT);
                        $news->bindValue(':datetri', $_POST['datetri'], PDO::PARAM_STR);
                        $news->execute();
                    }

                    foreach ($news as $row) {
                        $_SESSION['idnews'] = $row['idnews'];
                        echo '<article>';
                        include './affiche_news.php';
                        echo '</article>' . '</br> </br>';
                    }
                }
            } else {
                $maxnews = $objPdo->prepare("SELECT * FROM news");
                $maxnews->execute();

                foreach ($maxnews as $row) {
                    $_SESSION['idnews'] = $row['idnews'];
                    echo '<article>';
                    include './affiche_news.php';
                    echo '</article>' . '</br> </br>';
                }
            }
            ?>
        </section>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function MessageAlerte() {
        if (confirm("Souhaitez-vous vous deconnecter ?"))
            window.location.href = "../connexion/deconnexion.php"
    }
</script>

<footer>Valentin AZANCOTH - Alexandre FURET</footer>

</html>