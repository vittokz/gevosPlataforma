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
    
    $idAlerta   =  filter_var($obj->idAlerta,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $llamada    =  filter_var($obj->llamada, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $mensaje    =  filter_var($obj->mensaje, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d g:i a");  
    
    
    try {
        $stmt 	= $pdo->query("UPDATE ge_alerta_llamadas set estadoAlerta='Respondida',fechaRespuesta='$hoy',descripcionRespuesta='$mensaje',
        llamadaRealizada='$llamada' WHERE idAlerta='$idAlerta'");
        $data["resul"]= $stmt->rowCount();
        $mail = new PHPMailer(true);
                    //Server settings
                /*    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'vittoriocassetta@gmail.com';                     // SMTP username
                    $mail->Password   = 'Italiacamila03';                               // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
               
                    //Recipients
                    $mail->setFrom('vittorio15@hotmail.com', 'Notificaci&oacute;n GEVOSCOLOMBIA');
                    $mail->addAddress($email, 'Notificaci&oacute;n GEVOSCOLOMBIA');     // Add a recipient
                    // Attachments
                    //enviar archivos e imagenes
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    // Content
                    //$mail足>AddAttachment("ruta/archivo_adjunto.gif");
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Notificaci&oacute;n GEVOSCOLOMBIA';
                    $mail->Body    = '<h4>Informaci&oacute;n de la Notificaci&oacute;n</h4> ';
                    $mail->Body .= '<div style ="text-aling:justify">
                    En la fecha y hora  '.$hoy.' Se envia descripci&oacute;n de la notificaci&oacute;n .( '.$mensaje.' ).<br>  
                    Revisar la plataforma o la App para revisar la información. 
                    Se brinda respuesta al Cliente <br>Gracias por su atenci&oacute;n.</div>';
                    $mail->send();*/
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

