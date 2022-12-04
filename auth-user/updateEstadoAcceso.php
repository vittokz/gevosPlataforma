<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    
    
    $estado    =  filter_var($obj->estado, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $idenEmpleado   =  filter_var($obj->idenEmpleado,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         try {
            $stmt 	= $pdo->query("UPDATE ge_authUser set estado='$estado' where idenEmpleado like '$idenEmpleado'");
            $data["resul"]= $stmt->rowCount();
            // retorno datos en JSON
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }
     echo json_encode($data);
?>

