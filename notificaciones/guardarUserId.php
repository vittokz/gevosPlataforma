<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $identidad    =  filter_var($obj->identidad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $token   =  filter_var($obj->userId,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
 
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
        $stmt 	= $pdo->query("UPDATE ge_usuario set userIdMovil='$token', empresa='Gevos' where identidad like '$identidad'");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

