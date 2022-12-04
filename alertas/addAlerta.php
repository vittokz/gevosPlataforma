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
    
    $idAbogado    =  filter_var($obj->idAbogado,FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $fechaAlerta    =  filter_var($obj->fechaAlerta, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $horaAlerta    =  filter_var($obj->horaAlerta, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    $observacion  = strtoupper(filter_var($obj->observacion, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $estadoAlerta  = strtoupper(filter_var($obj->estadoAlerta, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
    $usuarioRegistro  = filter_var($obj->usuarioRegistro, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d g:i a");  
    
    $stmt 	= $pdo->query("select * from ge_empleado where cedula_empleado like '$idAbogado'") ;
    while($row  = $stmt->fetch(PDO::FETCH_OBJ))
    {
        $nombreCompleto = $row->nombre + " " + $row->apellido;
        $email = $row->email;
    } 
    
    try {
        $stmt 	= $pdo->query("INSERT INTO ge_alerta_llamadas (idAbogado,fechaAlerta,horaAlerta,observacion,estadoAlerta,fechaRegistro,usuarioRegistro) 
        VALUES ('$idAbogado','$fechaAlerta','$horaAlerta','$observacion','Pendiente','$hoy','$usuarioRegistro')");
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
               */
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
                    En la fecha y hora  '.$hoy.' Se envia descripci&oacute;n de la notificaci&oacute;n .( '.$observacion.' ).<br>  
                    Por favor revisar la plataforma para brindar respuesta al cliente lo mas pronto posible. 
                    Gracias por su atenci&oacute;n.</div>';
                    $mail->send();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

