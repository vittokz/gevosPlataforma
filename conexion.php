<?php
function conectarse(){
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
  header("Content-Type: application/json");
  // Define database connection parameters
  $hn      = 'localhost';
  $un      = 'gevos_colombia';
  $pwd     = 'gevos2020';
  $db      = 'bd_gevos';
  $cs      = 'utf8';
  // Set up the PDO parameters
  $dsn 	= "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
  $opt 	= array(
                      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                      PDO::ATTR_EMULATE_PREPARES   => false,
                    );
  // Create a PDO instance (connect to the database)
  $pdo 	= new PDO($dsn, $un, $pwd, $opt); 
   return $pdo;
    }
 
?>


