<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $idUsuario    =  filter_var($obj->idUsuario,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $tipoDoc    =  filter_var($obj->tipoDoc,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $identidad    =  filter_var($obj->identidad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $nombre  = strtoupper(filter_var($obj->nombre, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $apellido  = strtoupper(filter_var($obj->apellido, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $municipio  = filter_var($obj->municipio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $movil	  = filter_var($obj->movil, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $direccion    =  filter_var($obj->direccion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $email    =  filter_var($obj->email, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $tipoUsuario   =  filter_var($obj->tipoUsuario, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $estado   =  filter_var($obj->estado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $usuario   =  filter_var($obj->usuario, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    try {
        $stmt 	= $pdo->query("UPDATE ge_usuario set tipo='$tipoDoc',empresa='',nombre='$nombre',apellido='$apellido',
        municipio='$municipio',celular='$movil',direccion='$direccion',email='$email',estado='$estado',tipoUsuario='$tipoUsuario',
        fechaActivacion='$hoy',usuarioActiva='$usuario' where idUsuario like '$idUsuario'");
        $data["resul"]= $stmt->rowCount();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

