<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $descripcion    =  filter_var($obj->descripcion,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $estado    =  filter_var($obj->estado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $usuarioRegistro    =  filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
        $stmt 	= $pdo->query("INSERT INTO ge_soporte (descripcion,usuarioRegistro,fechaRegistro,estado) 
        VALUES ('$descripcion','$usuarioRegistro','$hoy','$estado')");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

