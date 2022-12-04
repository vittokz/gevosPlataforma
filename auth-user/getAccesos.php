<?php
    include("../conexion.php");
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
   
    $tipoUsuario = $_GET["tipoUsuario"];

    if($tipoUsuario=="1"){
      try {
        $stmt 	= $pdo->query("select ge_empleado.nombre,ge_empleado.apellido,ge_authUser.* from ge_authUser,ge_empleado
        where ge_authUser.tipoUsuario <> '4' and ge_authUser.idenEmpleado like ge_empleado.cedula_empleado
        order by ge_authUser.tipoUsuario DESC");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $data[] = $row;
       }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
    }
    else{
      try {
        $stmt 	= $pdo->query("select * from ge_authUser where tipoUsuario like '$tipoUsuario'  order by tipoUsuario DESC");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $data[] = $row;
       }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
    }
    
     echo json_encode($data);
?>

