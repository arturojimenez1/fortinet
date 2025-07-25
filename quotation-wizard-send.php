<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="HOMEALARMS - Alarms and security systems site template">
	<meta name="author" content="Ansonika">
	<title>KENDO - Seguridad a tu Alcance</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/fortiajolote.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/menu.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<link href="css/elegant_font/elegant_font.min.css" rel="stylesheet">
	<link href="css/fontello/css/fontello.min.css" rel="stylesheet">
    
	<script type="text/javascript">
    function delayedRedirect(){
        window.location = "index.html"
    }
    </script>

</head>
<body id="confirmation" onLoad="setTimeout('delayedRedirect()', 10000)">
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Inicializar variables
$admin_email = "arturo.jimenez@tikendo.com.mx";
$from_email = "arturo.jimenez@tikendo.com.mx";
$user_email = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$subject = "Cotización solicitada desde Tikendo Fortinet";

// Función auxiliar para sanitizar entradas
function sanitize_input($data) {
    return htmlspecialchars(trim(stripslashes($data)));
}

// Inicializar mensaje plano para email y mostrar
$message = "Nueva solicitud de cotización desde el sitio web de Tikendo\n\n";
$message .= "DETALLES DE LA SOLICITACIÓN\n";

// Paso 1: Tipo de solución
$tipo_seleccion = isset($_POST['tipo_seleccion']) ? sanitize_input($_POST['tipo_seleccion']) : '';
if ($tipo_seleccion) {
    $message .= "Tipo de solución: $tipo_seleccion\n";
}

// Paso 2: Detalles según tipo de solución
$tipos = [
    'servicios_tipo', 'hardware_tipo', 'licencia_tipo'
];
foreach ($tipos as $tipo) {
    if (isset($_POST[$tipo])) {
        $message .= ucwords(str_replace('_', ' ', $tipo)) . ": " . sanitize_input($_POST[$tipo]) . "\n";
    }
}

// Paso 3 y 4: Campos adicionales
$campos = [
    'implementacion_tipo', 'soporte_tipo', 'capacitacion_tipo', 'fortigate_usuarios',
    'switch_puertos', 'fortiap_ubicacion', 'fortimail_volumen', 'analyzer_logs',
    'forticare_cobertura', 'seguridad_tipo', 'capacidad_tipo', 'dispositivo_tipo',
    'adicional_tipo', 'implementacion_fortigate', 'implementacion_fortiap',
    'implementacion_fortimail', 'implementacion_fortiswitch', 'soporte_bolsa',
    'soporte_contrato', 'soporte_emergente', 'capacitacion_modalidad',
    'fortigate_conectividad', 'fortiswitch_conectividad', 'fortiap_usuarios',
    'fortimail_almacenamiento', 'fortianalyzer_monitoreo', 'forticare_respuesta',
    'seguridad_tiempo', 'capacidad_tiempo', 'dispositivo_tiempo', 'adicional_tiempo'
];
foreach ($campos as $campo) {
    if (isset($_POST[$campo])) {
        $message .= ucwords(str_replace('_', ' ', $campo)) . ": " . sanitize_input($_POST[$campo]) . "\n";
    }
}

// Paso 5: Detalles del usuario
$nombre = isset($_POST['nombre']) ? sanitize_input($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? sanitize_input($_POST['apellido']) : '';
$telefono = isset($_POST['telefono']) ? sanitize_input($_POST['telefono']) : '';
$comentarios = isset($_POST['comentarios']) ? sanitize_input($_POST['comentarios']) : '';

$message .= "\nDETALLES DEL USUARIO\n";
$message .= "Nombre: $nombre\n";
$message .= "Apellido: $apellido\n";
$message .= "Teléfono: $telefono\n";
$message .= "Correo: $user_email\n";
$message .= "Comentarios: $comentarios\n";

// Construir cuerpo HTML para correo (usando mensaje plano para resumen dentro del diseño)
$user_name = htmlspecialchars($nombre . ' ' . $apellido);
$htmlMessage = "
<html>
<head>
  <style>
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background-color: #f7f9fc;
      color: #333;
      margin: 0; padding: 0;
    }
    .container {
      max-width: 600px;
      background: white;
      margin: 30px auto;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
      color: #007bff;
      margin-bottom: 20px;
      font-weight: 700;
    }
    p {
      line-height: 1.6;
      margin-bottom: 10px;
    }
    .details {
      background-color: #eef4fb;
      padding: 15px;
      border-radius: 6px;
      margin-top: 20px;
      font-size: 14px;
      white-space: pre-wrap;
      font-family: 'Poppins', monospace;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #999;
      text-align: center;
    }
    .highlight {
      color: #28a745;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class='container'>
    <h2>Gracias por tu solicitud, $user_name</h2>
    <p>Hemos recibido tu solicitud de cotización y pronto nos pondremos en contacto contigo.</p>
    <p>Resumen de tu solicitud:</p>
    <div class='details'>$message</div>
    <p class='highlight'>Equipo Tikendo</p>
    <div class='footer'>&copy; " . date('Y') . " Tikendo. Todos los derechos reservados.</div>
  </div>
</body>
</html>
";

// Enviar con PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = $from_email;
    $mail->Password = 'Tikendo2025$'; // Reemplaza con tu contraseña real
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Correo al administrador (texto plano)
    $mail->setFrom($from_email, 'Tikendo');
    $mail->addAddress($admin_email);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = strip_tags($message);
    $mail->isHTML(false);
    $mail->send();

    // Confirmación al usuario (con HTML)
    if (!empty($user_email)) {
        $mail->clearAddresses();
        $mail->addAddress($user_email);
        $mail->Subject = "Gracias por tu solicitud de cotización - Tikendo";
        $mail->Body = $htmlMessage;
        $mail->AltBody = strip_tags($message);
        $mail->isHTML(true);
        $mail->send();
    }

    echo "Correo enviado correctamente.";

} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>



<!-- END SEND MAIL SCRIPT -->   
<div id="success">
	<div class="icon icon--order-success svg">
		<svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                <g fill="none" stroke="#8EC343" stroke-width="2">
                  <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                  <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                </g>
              </svg>
	</div>
	<h4><span>Thank you!</span>Quotation request sent.</h4>
	<small>You will be redirect back in 10 seconds.</small>
</div>
</body>
</html>