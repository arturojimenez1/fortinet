<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com'; // Cambia si usas Gmail u otro
    $mail->SMTPAuth = true;
    $mail->Username = 'arturo.jimenez@tikendo.com.mx'; // Tu correo real
    $mail->Password = 'Tikendo2025$';      // Tu contraseña SMTP real
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('arturo.jimenez@tikendo.com.mx', 'Tikendo');
    $mail->addAddress('arturo.jimenez@tikendo.com.mx');

    // Contenido del correo
    $mail->isHTML(false); // O true si quieres HTML
    $mail->Subject = 'Prueba desde PHPMailer';
    $mail->Body    = 'Este es un correo de prueba enviado desde PHPMailer en XAMPP';

    $mail->send();
    echo 'Correo enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
