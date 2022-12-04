<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $idenEmpleado   =  filter_var($obj->idenEmpleado,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $clave    =  filter_var($obj->clave, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $usuarioRegistro  = filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $tipoUsuario  = filter_var($obj->tipoUsuario, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    $stmt 	= $pdo->query("SELECT * FROM ge_authUser where idenEmpleado like '$idenEmpleado'");
      if($stmt->rowCount()<=0){
         try {
            $stmt 	= $pdo->query("INSERT INTO ge_authUser (idenEmpleado,clave_usuario,fechaRegistro,estado,usuarioRegistro,tipoUsuario) 
            VALUES ('$idenEmpleado','$clave','$hoy','Activo','$usuarioRegistro','$tipoUsuario')");
            $data["resul"]= $stmt->rowCount();
            // retorno datos en JSON
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }
      }
      else{
         $data["resul"]= -1;
      }
    
     echo json_encode($data);
?>

