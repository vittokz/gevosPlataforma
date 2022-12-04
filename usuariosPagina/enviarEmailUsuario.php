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
    $identidad    =  filter_var($obj->identidad,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $hoy = date("Y-m-d g:i a");  
    
    $stmt 	= $pdo->query("select clave_usuario from ge_authUser where idenEmpleado like '$identidad'");
        while($rowU  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $clave = $rowU->clave_usuario;
       }
    try {
        $stmt 	= $pdo->query("select * from ge_usuario where identidad like '$identidad'");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
       {
         $email = $row->email;
         $nombreCompleto = $row->nombre." ".$row->apellido;
         
         $mail = new PHPMailer(true);
         $mail->setFrom('vittorio15@hotmail.com', 'Notificaci&oacute;n GEVOSCOLOMBIA');
         $mail->addAddress($email, 'Notificaci&oacute;n GEVOSCOLOMBIA');     // Add a recipient
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = 'Notificaci&oacute;n GEVOSCOLOMBIA';
         $mail->Body    = '<h4>Informaci&oacute;n creaci&oacute;n de Acceso</h4> ';
         $mail->Body .= '<div style ="text-aling:justify">
         En la fecha y hora  '.$hoy.' Se envia datos de acceso a la plataforma GEVOS COLOMBIA.<br>  
         Cliente '.strtoupper($nombreCompleto).' identificado con cedula de ciudadan&iacute;a N&uacute;mero. 
         '.$identidad.'.<br>
         USUARIO: '.$identidad.'<br> Clave: '.$clave.' <br><br>Gracias por su atenci&oacute;n.</div>';
         $mail->send();
         $data["resul"]= $stmt->rowCount();
       }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

