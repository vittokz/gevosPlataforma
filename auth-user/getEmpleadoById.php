<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    $identidad = $_GET["identidad"];

    try {
        $stmt 	= $pdo->query("select * from ge_empleado where cedula_empleado like '$identidad'");
        if($stmt->rowCount() > 0 ){
              while($row  = $stmt->fetch(PDO::FETCH_OBJ))
            {
              $data[] = $row;
            }
        }
        else{
          $data["resul"] = "-1";
        }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

