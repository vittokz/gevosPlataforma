<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    $id = $_GET["id"];

    try {
        $stmt 	= $pdo->query("select * from ge_empleado where id_empleado like '$id'");
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

