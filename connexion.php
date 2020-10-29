<?php
$db_config = array();
$db_config['SGBD'] = 'mysql';
$db_config['HOST'] = 'localhost';
$db_config['DB_NAME'] = 'azancoth1u_projetweb';
$db_config['USER'] = 'root';
$db_config['PASSWORD'] = 'root';
try {
    $objPdo = new PDO($db_config['SGBD'] . ':host=' . $db_config['HOST'] . ';dbname=' .
        $db_config['DB_NAME'], $db_config['USER'], $db_config['PASSWORD']);
    //echo '<span style="display: none;">connexion ok</span>';
    unset($db_config);
} catch (Exception $exception) {
    die($exception->getMessage());
}
