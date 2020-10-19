<?php
session_start();
if(isset($_POST['user']) && isset($_SESSION['mdp'])) 
{
    $bSoumis = 1;
    header('identification.php');
    if($_POST['user'] == 'valaz' && $_POST['mdp'] == 'secret') 
    {
        $_SESSION['isLogged']=true;
        if(isset($_POST['url']!='')) 
        {
            header('Location:' . $_POST['url']);
        }
        else
        {
            header('Location:accueil.php');
        }
    }
}
if (isset($_SESSION["isLogged"]))
    header('Location:index.php');

if (isset($_POST['url']))
    echo 'Pour accèder à cette page il est nécessaire de se connecter avec votre identifiant :';
?>

<html>
    <head>
        <title >Identification</title >
    </head>
    <body>
        <form method="post" action="identification.php">
           <h1>Pour accéder à cette page il est nécessaire de se connecter avec votre identifiant</h1>
           <label>Login</label> </br>
           <input type="text" value="" name="user"> </br>
           <label>Password</label> </br>
           <input type="text" value="" name="mdp"> </br> </br>
           <input type="submit" value="Validez" name="valider">
        </form>
    </body>
</html>

<?php
if($bSoumis !== 1)
    echo '<h3> Désolé, réessayer ! </h3>';
else
    echo 'pour accéder à cette page il est nécessaire de se connecter avec votre identifiant';
?>