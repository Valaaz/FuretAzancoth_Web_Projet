<?php
include 'connexion.php';

session_start();
?>

<body>
    <?php
    $query = $objPdo->prepare("SELECT * FROM news WHERE idnews = 1");
    $query->execute();
    while ($row = $query->fetch()) {
        echo $row['titrenews'] . '<br>';
        echo $row['textenews'] . '<br>';
    }
    ?>
</body>