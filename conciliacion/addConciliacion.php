<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $convocantes    =  filter_var($obj->convocantes,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $convocados    =  filter_var($obj->convocados, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $idenCliente  = strtoupper(filter_var($obj->idenCliente, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $usuarioRegistro  = strtoupper(filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
        $stmt 	= $pdo->query("INSERT INTO ge_cliente_conciliacion
        (idenCliente,convocantes,convocados,fechaRegistro,usuarioRegistro) 
        VALUES ('$idenCliente','$convocantes','$convocados','$hoy','$usuarioRegistro')");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

