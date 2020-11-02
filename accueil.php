<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="css/accueil.css" />
</head>

<body>
    <header>
        <?php
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

    <h1>Bienvenue à l'accueil</h1>

    <?php
    include 'connexion.php';
    $id = 1;

    $query = $objPdo->prepare("SELECT * FROM news WHERE idnews = :id");
    $query->bindvalue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $maxnews = "SELECT COUNT(*) FROM news";
    $max = $objPdo->query($maxnews);

    for ($id; $id <= 2; $id++) {
        $_SESSION['idnews'] = $id;
        echo '<article>';
        include 'affiche_news.php';
        echo '</article>' . '</br> </br>';
    }
    ?>
</body>

<script language="javascript" type="text/javascript">
    function MessageAlerte() {
        if (confirm("Souhaitez-vous vous deconnecter ?"))
            window.location.href = "deconnexion.php"
    }
</script>

<footer>Valentin AZANCOTH - Alexandre FURET</footer>

</html>