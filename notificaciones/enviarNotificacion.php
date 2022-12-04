<?php

function sendGCM($message, $id) { 
    $url = 'https://fcm.googleapis.com/fcm/send'; 
    $fields = array ( 'registration_ids' => array ( $id ), 
     'data' => array ( "message" => $message ) ); 
    $fields = json_encode ( $fields ); 
    $headers = array ( 'Authorization: key=AAAApv9o9kY:APA91bGH-dsYIUfkDu_s-rpubA4zbuR9tfH_JKjQG3SwuwFeFvJbJM4pHNwbNYS8bjiqPeBBa9Yx1_xxMOiF4yBKJWl3dXRbO6CRqyGhurtCLS_iQnSZfIwG5A5I_gebZ4HWI8nPgEwS', 'Content-Type: application/json' ); 
    $ch = curl_init (); 
    curl_setopt ( $ch, CURLOPT_URL, $url ); 
    curl_setopt ( $ch, CURLOPT_POST, true ); 
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers ); 
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true ); 
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields); 
    $result = curl_exec ( $ch ); 
    echo $result; 
    curl_close ( $ch ); 
}

sendGCM("Pruebas notificaciones gevos - vittorio php","ei9v2jAx_8g:APA91bFxExihUTH2n49ZSbuRVRqVUNSMx_NBjfznyo57Et8B16dMjn9wOPQ9QgOforr2xLVQljqVYmuIxstxs5wO6GkIBZ-q9ME6A-x0UUP3a3wbTWheM0twFRX2T5ldKX5TtqKJPBRt");

?> 
      
      