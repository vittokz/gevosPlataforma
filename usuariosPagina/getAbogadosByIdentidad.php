<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    $identidad    =  $_GET["identidad"];
    try {
        $stmt 	= $pdo->query("select identidadAbogado from ge_usuario_asignacionAbogado where identidadUsuario like '$identidad'");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $identidadAbogado = $row->identidadAbogado;
         $stmt2	= $pdo->query("select * from ge_empleado where cedula_empleado like '$identidadAbogado'");
         while($row2  = $stmt2->fetch(PDO::FETCH_OBJ))
           {
            $data[] = $row2;
           }
       }
     } 
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

