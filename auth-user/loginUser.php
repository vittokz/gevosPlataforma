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
        $stmt 	= $pdo->query("select * from ge_authUser where idenEmpleado like '$identidad' and clave_usuario like '$clave' and estado like 'Activo'");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

