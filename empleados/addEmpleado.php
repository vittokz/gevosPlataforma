<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    $tipoDoc   =  filter_var($obj->tipoDoc,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $identidad    =  filter_var($obj->identidad, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $nombre  = filter_var($obj->nombre, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $apellido  = filter_var($obj->apellido, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $empresa  = "Gevos";
    $municipio  = filter_var($obj->municipio, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $departamento  = filter_var($obj->departamento, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $movil  = filter_var($obj->movil, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $telefono  = $movil;
    $direccion  = filter_var($obj->direccion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $email = filter_var($obj->email, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $usuarioRegistro  = filter_var($obj->usuario, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $estado = "Activo";
    $email = strtolower($email);
  
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d");         
    
    $stmt 	= $pdo->query("SELECT * FROM ge_authUser where idenEmpleado like '$identidad'");
      if($stmt->rowCount()<=0){
         try {
            $stmt 	= $pdo->query("INSERT INTO ge_empleado (tipo,cedula_empleado,empresa,nombre,apellido,municipio,departamento,telefono,celular,direccion,email,estado,usuario,fechaRegistro,tipoEmpleado,especialidad) 
            VALUES ('$tipoDoc','$identidad','$empresa','$nombre','$apellido','$municipio','$departamento','$telefono','$movil','$direccion','$email','Activo','$usuarioRegistro','$hoy','3','no')");
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

