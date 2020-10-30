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
        } else if (isset($_SESSION['isLogged']) == false) {
            $co = '<a href="identification.php"> Se connecter </a> <br>';
			$re = '<a href="creercompte.php"> Creer un compte </a> <br>';
            echo $co;
			echo $re;
        }
        ?>
    </header>

    <h1>Bienvenue a l'accueil</h1>

    <article>Article</article>
</body>

<script language=" javascript " type="text/javascript">
    function MessageAlerte() {
        if (confirm("Souhaitez-vous vous deconnecter ?"))
            window.location.href = "deconnexion.php"
    }
</script>

<footer>Valentin AZANCOTH - Alexandre FURET</footer>

</html>