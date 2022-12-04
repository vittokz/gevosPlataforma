<?php
    include("../conexion.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../phpMailer/Exception.php';
    require '../phpMailer/PHPMailer.php';
    require '../phpMailer/SMTP.php';
    $pdo = conectarse();
    $data    = array();
    // Retrieve the posted data
    $json    =  file_get_contents('php://input');
    $obj     =  json_decode($json);
    $identidad    =  $_GET["identidad"];
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d g:i a");
    try {
        $stmt 	= $pdo->query("select * from ge_usuario where identidad like '$identidad' and estado like 'Activo'");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
         {
         $email = $row->email;
         $stmt2 	= $pdo->query("select * from ge_authUser where idenEmpleado like '$identidad' and estado like 'Activo'");
         while($row2  = $stmt2->fetch(PDO::FETCH_OBJ))
           {
                    $clave = $row2->clave_usuario;
                    $mail = new PHPMailer(true);
                    $mail->setFrom('vittorio15@hotmail.com', 'Notificaci&oacute;n GEVOSCOLOMBIA');
                    $mail->addAddress($email, 'Notificaci&oacute;n GEVOSCOLOMBIA');     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Notificaci&oacute;n GEVOSCOLOMBIA';
                    $mail->Body    = '<h4>Informaci&oacute;n de la Notificaci&oacute;n</h4> ';
                    $mail->Body .= '<div style ="text-aling:justify">
                    En la fecha y hora  '.$hoy.' Se envia recuperaci&oacute;n de contraseña ( '.$clave.' )<br>  
                    Con esta contraseña puede acceder a la App Gevos Colombia. 
                    Gracias por su atenci&oacute;n.</div>';
                    $mail->send();
                    $data["resul"]= $stmt->rowCount();
           }
       }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

