<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $nombre    =  filter_var($obj->nombre, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $municipio  = strtoupper(filter_var($obj->municipio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $usuarioRegistro  = filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
         $stmt 	= $pdo->query("INSERT INTO ge_juzgados(nombre,ciudad,usuario,estado) 
         VALUES ('$nombre','$municipio','$usuarioRegistro','Activo')");
         $data["resul"]= $stmt->rowCount();
         // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

