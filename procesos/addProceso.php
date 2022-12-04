<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $identidadCliente   =  filter_var($obj->identidadCliente,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $radicado    =  filter_var($obj->radicado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $demandante    =  filter_var($obj->demandante, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $demandado  = strtoupper(filter_var($obj->demandado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $departamento  = strtoupper(filter_var($obj->departamento, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $municipio  = strtoupper(filter_var($obj->municipio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $juzgado  = strtoupper(filter_var($obj->juzgado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $fechaCreacion  = strtoupper(filter_var($obj->fechaCreacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $usuarioRegistro  = filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
        $cant = strlen($radicado);
        if($cant < 24 && $cant > 22){
         $stmt 	= $pdo->query("INSERT INTO ge_cliente_proceso (identidadCliente,radicado,demandante,demandado,departamento,
         municipio,juzgado,fechaCreacion,fechaRegistro,usuarioRegistro) 
         VALUES ('$identidadCliente','$radicado','$demandante','$demandado','$departamento','$municipio','$juzgado',
         '$fechaCreacion','$hoy','$usuarioRegistro')");
         $data["resul"]= $stmt->rowCount();
         // retorno datos en JSON
        }
        else{
         $data["resul"]="-1"; 
        }
        
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

