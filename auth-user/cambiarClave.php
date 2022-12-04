<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $identidad    =  filter_var($obj->identidad,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $clave    =  filter_var($obj->clave, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    
    try {
        $stmt 	= $pdo->query("UPDATE ge_authUser  set clave_usuario='$clave' where idenEmpleado like '$identidad'");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

