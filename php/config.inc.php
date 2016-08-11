<?php
//Konfigurationsdaten

// DB Konstanten
define('MYSQL_HOST', 'mysql5');
define('MYSQL_USER', 'kblumenstein');
define('MYSQL_PASS', 'H5TmC9XD');
define('MYSQL_DATABASE', 'db_kblumenstein_1');

// local
/*define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DATABASE', 'db_kblumenstein_1');*/

// LDAP
define('LDAP_SERVER','195.202.144.1');
define('LDAP_SERVER_PORT',41389);
define('LDAP_BIND_USER','');
define('LDAP_BIND_PW','');
define('LDAP_BASE','OU=FH,DC=fhstp,DC=local');


// Datenbankverbindung herstellen
function connectDB(){
    try{
        $db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE, MYSQL_USER, MYSQL_PASS);
    } catch(PDOException $e){
        echo "<error>Verbindungsfehler: ".$e->getMessage()."! Fehler beim Verbinden mit der DB!</error>";
        exit;
    }
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return  $db;
}

// Datenbankverbindung kappen
function disconnectDB($db) {
    $db = null;
}


?>
