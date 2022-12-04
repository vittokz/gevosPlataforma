<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
 
    try {
        $stmt 	= $pdo->query("select * from ge_usuario where tipoUsuario like 'Cliente' and estado like 'Activo'");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $data[] = $row;
       }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

