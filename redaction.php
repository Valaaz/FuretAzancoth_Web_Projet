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
        <input type="text" value="" name="theme"> </br>

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
        </select>

        <label>Contenu</label> </br>
        <input type="text" value="" name="contenu"> </br>

        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>