<?php


?>

<html>

<head>
    <title>Voir une news</title>
    <link rel="stylesheet" href="css/detail_news.css" />
</head>

<body>
    <header>
        <h1>Détail d'une news</h1>
    </header>
    <hr>
    <label>Titre</label> </br>
    <input class="conteneur" id="titre" type="text" value="<?php echo $_GET['titre'] ?>" name="titre" readonly> </br>

    <label>Thème</label> </br>
    <input class="conteneur" id="theme" type="text" value="<?php echo $_GET['theme'] ?>" name="theme" readonly> </br>

    <label>Contenu</label> </br>
    <textarea class="conteneur" name="contenu" id="contenu" rows="40" cols="100" wrap="hard" readonly><?php echo $_GET['contenu'] ?></textarea> </br>

    <input class="retour" type="button" value="Retour" name="annuler" onclick="Annuler()">

    </form>
</body>

<script language="javascript" type="text/javascript">
    function Annuler() {
        if (confirm("Souhaitez-vous retourner à l'accueil ?"))
            window.location.href = "accueil.php"
    }
</script>

</html>