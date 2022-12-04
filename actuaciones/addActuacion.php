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
    
    $identidad = $_POST["identidad"];
    $idProceso = $_POST["idProceso"];
    $fecha = $_POST["fecha"];
    $descripcion = $_POST["descripcion"];
    $usuarioRegistro = $_POST["usuarioRegistro"];

    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d g:i a");   

        $upload_dir = 'img';
        $server_url = 'img/'.$identidad;
        if (!file_exists($server_url)) {
           mkdir($server_url, 0777, true);
        }
   
       if($_FILES['avatar'])
       {
           $avatar_name = $_FILES["avatar"]["name"];
           $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
           $error = $_FILES["avatar"]["error"];
  
           if($error > 0){
               $response = array(
                   "status" => "error",
                   "error" => true,
                   "message" => "Error uploading the file!"
               );
           }else 
           {
               $upload_name = $avatar_name;
           
               if(move_uploaded_file($avatar_tmp_name , $server_url."/".$upload_name)) {
                   $response = array(
                       "status" => "success",
                       "error" => false,
                       "message" => "File uploaded successfully",
                       "url" => $server_url."/".$upload_name
                   );
               }else
               {
                   $response = array(
                       "status" => "error",
                       "error" => true,
                       "message" => "Error uploading the file!"
                   );
               }
           }    
       }else{
           $response = array(
               "status" => "error",
               "error" => true,
               "message" => "No file was sent!"
           );
       }

    try {
        $stmt 	= $pdo->query("select * from ge_usuario where identidad like '$identidad' and estado like 'Activo'");
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
        {
         $email = $row->email;
        }

        $stmt 	= $pdo->query("insert into ge_cliente_actuacion(identidadCliente,idProceso,fechaActuacion,descripcion,
        nombreArchivo,fechaRegistro,usuarioRegistro) 
        VALUES ('$identidad','$idProceso','$fecha','$descripcion','$upload_name','$hoy','$usuarioRegistro')");
        $data['resul'] = "ok";
                $mail = new PHPMailer(true);
                    $mail->setFrom('vittorio15@hotmail.com', 'Notificaci&oacute;n GEVOSCOLOMBIA-ACTUACION');
                    $mail->addAddress($email, 'Notificaci&oacute;n GEVOSCOLOMBIA');     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Notificaci&oacute;n GEVOSCOLOMBIA ACTUACION';
                    $mail->Body    = '<h4>Informaci&oacute;n de la Notificaci&oacute;n</h4> ';
                    $mail->Body .= '<div style ="text-aling:justify">
                    En la fecha  '.$fecha.' Se registra la siguiente actuaci&oacute;n: ( '.$descripcion.' ).<br>  
                    Por favor revisar la plataforma o la App para acceder a la informaci&oacute;n completa de la 
                    notificaci&oacute;n</div>';
                    $mail->send();
        // retorno datos en JSON
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
     echo json_encode($data);
?>

