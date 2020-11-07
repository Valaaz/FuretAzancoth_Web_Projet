<?php
include '../connexion/connexion.php';

$suppnews = $objPdo->prepare("DELETE FROM news WHERE idnews = :idnews");
$suppnews->bindvalue(':idnews', $_GET['idnews'], PDO::PARAM_INT);
if ($suppnews->execute())
    header('Location:../affichage/mesnews.php');
else
    echo 'Erreur MySQL';
