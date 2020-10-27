<?php
session_start();
if (isset($_POST['valider'])) {
    if (isset($_POST["utilisateur"]) and isset($_POST["mdp"]))
        if ($_POST["utilisateur"] == "valaz" and $_POST["mdp"] == "val") {
            $_SESSION["isLogged"] = true;
            if (isset($_GET['target']))
                header('Location:' . $_GET["target"]);
            else
                header('Location:accueil.html');
        }
}
if (isset($_SESSION["isLogged"]))
    header('Location:accueil.html');

if (isset($_POST['url']))
    echo 'Vous devez vous connecter si vous voulez accéder à cette page :';
?>

<html>

<head>
    <title>Identification</title>
</head>

<body>
    <form method="post" action="identification.php">
        <h1>Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant</h1>
        <label>Identifiant</label> </br>
        <input type="text" value="" name="utilisateur"> </br>
        <label>Mot de passe</label> </br>
        <input type="text" value="" name="mdp"> </br> </br>
        <input type="submit" value="Validez" name="valider">
    </form>
</body>

</html>