<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="css/accueil.css" />
</head>

<body>
    <header>
        <?php
        include 'connexion.php';
        session_start();

        $co = array();
        $re = array();
        if (isset($_SESSION['isLogged'])) {
            $co = '<a href="#" onclick="MessageAlerte()"> Se deconnecter </a> <br>';
            echo $co;
            echo '<a href="redaction.php" target="_blank"> Redacteur </a> <br>';
            // Affichage du pseudo de l'utilisateur connecté
            echo 'Connecté : ' . $_SESSION['pseudo'] . '<br>';
            // Affichage du mail de l'utilisateur connecté
            echo 'Mail : ' . $_SESSION['mail'];
        } else if (isset($_SESSION['isLogged']) == false) {
            $co = '<a href="identification.php"> Se connecter </a> <br>';
            echo '<a href="creercompte.php"> Creer un compte </a> <br>';
            echo $co;
        }
        ?>
    </header>

    <form method="POST">
        <h1>Bienvenue à l'accueil</h1>

        <label>Trier par thème</label> </br>
        <select name="themetri">
            <option value='0'>Tous</option>

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

        <input type="submit" value="Valider" name="valider">

        <?php

        if (isset($_POST['valider'])) {
            if ($_POST['themetri'] == 0) {
                $maxnews = $objPdo->prepare("SELECT * FROM news");
                $maxnews->execute();

                foreach ($maxnews as $row) {
                    $_SESSION['idnews'] = $row['idnews'];
                    echo '<article>';
                    include 'affiche_news.php';
                    echo '</article>' . '</br> </br>';
                }
            } else {
                $news = $objPdo->prepare("SELECT * FROM news WHERE idnews = :tri");
                $news->bindValue(':tri', $_POST['themetri'], PDO::PARAM_INT);
                $news->execute();

                foreach ($news as $row) {
                    $_SESSION['idnews'] = $row['idnews'];
                    echo '<article>';
                    include 'affiche_news.php';
                    echo '</article>' . '</br> </br>';
                }
            }
        } else {
            $maxnews = $objPdo->prepare("SELECT * FROM news");
            $maxnews->execute();

            foreach ($maxnews as $row) {
                $_SESSION['idnews'] = $row['idnews'];
                echo '<article>';
                include 'affiche_news.php';
                echo '</article>' . '</br> </br>';
            }
        }
        ?>
    </form>
</body>

<script language="javascript" type="text/javascript">
    function MessageAlerte() {
        if (confirm("Souhaitez-vous vous deconnecter ?"))
            window.location.href = "deconnexion.php"
    }
</script>

<footer>Valentin AZANCOTH - Alexandre FURET</footer>

</html>