<?php

$pdostat = $objPdo->prepare("INSERT INTO `news`(`titrenews`, `textenews`) VALUES(:titrenews, :textenews);");
$pdostat->bindvalue(':titrenews', $titrenews, PDO::PARAM_STR);
$pdostat->bindvalue(':textenews', $textenews, PDO::PARAM_STR);
if (!$pdostat->execute()) { // Si le résultat de la requête est faux ou null, c'est qu'il y a eu un problème
                $err_inscription[] = 'Erreur MySQL.';

?>
<html>

<head>
    <title>Rédaction</title>
    Bonjour rédacteur !
</head>

<body>
    <form method="post" action="creernews.php">
        <h1>Créer une news</h1>
        <label>Titre</label> </br>
        <input type="text" value="" name="titre"> </br>

        <label>Thème</label> </br>

        <select name='material'>
            <option value=''></option>

            <?php
            include 'connexion.php';

            $query = $objPdo->prepare("SELECT * FROM theme");
            $query->execute();
            foreach ($query as $row) {
                echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
            }
            ?>
        </select> </br>

        <label>Contenu</label> </br>
        <input type="text" value="" name="contenu"> </br>

        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>