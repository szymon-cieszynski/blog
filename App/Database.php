<?php
$config = require_once 'Config.php';

/**
* Database file - responsible for rconnecting to data base, using PDO library. 
* It also handles error messages.
*/
try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8",
        $config['user'],
        $config['password'],
        [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $error) {

    echo $error->getMessage(); //only error message
    exit('SC_: Database error!!!!'); 
}