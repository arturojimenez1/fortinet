<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="KENDO - Seguridad a tu Alcance">
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
$subject = "Nueva Solicitud de Cotización - Tikendo Fortinet";

// Función auxiliar para sanitizar entradas
function sanitize_input($data) {
    return htmlspecialchars(trim(stripslashes($data)));
}

// Inicializar mensaje plano para email y mostrar
$message = "Nueva solicitud de cotización recibida desde el sitio web de Tikendo\n\n";
$message .= "DETALLES DE LA SOLICITUD\n";

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

$message .= "\nDETALLES DEL SOLICITANTE\n";
$message .= "Nombre: $nombre\n";
$message .= "Apellido: $apellido\n";
$message .= "Teléfono: $telefono\n";
$message .= "Correo: $user_email\n";
$message .= "Comentarios: $comentarios\n";

$user_name = htmlspecialchars($nombre . ' ' . $apellido);
$htmlMessage = "
<html>
  <body style='margin: 0; padding: 0; font-family: Poppins, Arial, sans-serif; background-color: #f5f6fa;'>
    <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 650px; padding: 40px 20px;'>
      <tr>
        <td align='center'>
          <table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);'>
            <tr>
              <td align='center' style='padding: 30px 20px; background: linear-gradient(135deg, #000000ff, #000000ff);'>
                <img src='cid:logo_cid' alt='Tikendo Logo' style='max-width: 120px; height: auto; margin-bottom: 10px;'>
                <h1 style='color: #ffffff; font-size: 28px; font-weight: 600; margin: 0;'>Tikendo Fortinet</h1>
                <p style='color: #e6f0ff; font-size: 16px; font-weight: 400; margin: 5px 0 0;'>KENDO - Seguridad a tu Alcance</p>
              </td>
            </tr>
            <tr>
              <td style='padding: 40px 30px; font-size: 16px; color: #2d3748; line-height: 1.6;'>
                <p style='margin: 0 0 20px; font-weight: 500;'>Estimado equipo,</p>
                <p>Se ha recibido una nueva solicitud de cotización a través del sitio web de Tikendo Fortinet. A continuación, se detallan los datos proporcionados:</p>
                <div style='background-color: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #ff0000ff; font-size: 14px; white-space: pre-wrap; font-family: monospace; color: #2d3748;'>
                  $message
                </div>
                <p style='margin: 30px 0 20px;'>Por favor, pónganse en contacto con el solicitante para dar seguimiento a la brevedad.</p>
                <p style='margin: 0; font-weight: 500; color: #000000ff;'>Atentamente,<br>Equipo Tikendo</p>
              </td>
            </tr>
            <tr>
              <td align='center' style='padding: 25px; background-color: #f8fafc; font-size: 13px; color: #718096;'>
                &copy; " . date('Y') . " Tikendo. Todos los derechos reservados.<br>
                <a href='' style='color: #000000ff; text-decoration: none; font-weight: 500;'></a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
";

// Enviar con PHPMailer
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';       // Corrige acentos
$mail->Encoding = 'base64';     // Evita caracteres raros

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = $from_email;
    $mail->Password = 'Tikendo2025$'; // Reemplaza con tu contraseña real
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Incrustar el logo
    $logo_path = __DIR__ . '/img/fortiajolote.png';
    if (file_exists($logo_path)) {
        $mail->addEmbeddedImage($logo_path, 'logo_cid', 'fortiajolote.png');
    } else {
        throw new Exception('El archivo del logo no se encuentra en: ' . $logo_path);
    }

    // Correo al administrador
    $mail->setFrom($from_email, 'Sitio Web Tikendo');
    if (!empty($user_email)) {
        $mail->addReplyTo($user_email, $user_name);
    }
    $mail->addAddress($admin_email);
    $mail->Subject = $subject;
    $mail->Body = $htmlMessage;
    $mail->AltBody = strip_tags($message);
    $mail->isHTML(true);
    $mail->send();

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
	<h4><span>¡Gracias!</span> Solicitud de cotización enviada.</h4>
	<small>Serás redirigido a la página de inicio nuevamente en 10 segundos.</small>
</div>
</body>
</html>