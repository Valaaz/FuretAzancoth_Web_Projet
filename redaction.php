<html>

<head>
    <title>Rédaction</title>
	Bonjour rédacteur !
</head>

<body>
    <form method="post" action="creernews.php">
        <?php if (!empty($err_inscription)) { ?>
            <div class="error"><?php echo implode('<br/>', $err_inscription); ?></div>
        <?php     } ?>
        <h1>Créer une news</h1>
        <label>Titre</label> </br>
        <input type="text" value="" name="titre"> </br>

        <label>Thème</label> </br>
        <input type="text" value="" name="theme"> </br>

        <label>Contenu</label> </br>
        <input type="text" value="" name="contenu"> </br>
		
        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>