<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    $idAlerta = $_GET["idAlerta"];

    try {
        $stmt 	= $pdo->query("select * from ge_alerta_llamadas where idAlerta like '$idAlerta'");
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

