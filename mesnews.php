<head>
    <title>Mes news</title>
    <link rel="stylesheet" href="css/mesnews.css" />
</head>

<body>
    <header>
        <h1>Mes news</h1>
        <a class="retour" href="#" onclick="Annuler()"> Retour à l'accueil </a> </br>
    </header>

    <hr>

    <section>
        <?php
        include 'connexion.php';
        session_start();

        $mesnews = $objPdo->prepare("SELECT * FROM news WHERE idredacteur = :idredac");
        $mesnews->bindValue('idredac', $_SESSION['id'], PDO::PARAM_INT);
        $mesnews->execute();

        foreach ($mesnews as $row) {
            $_SESSION['idnews'] = $row['idnews'];
            echo '<article>';
            include 'affiche_mesnews.php';
            echo '</article>' . '</br> </br>';
        }
        ?>
    </section>

    <script language="javascript" type="text/javascript">
        function Annuler() {
            if (confirm("Souhaitez-vous revenir à l'accueil ?"))
                window.location.href = "accueil.php"
        }
    </script>
</body>