<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../../modelo/Sesion.php';
include_once '../../modelo/usuario.php';
include_once '../../modelo/dao/clienteDAO.php';
session_start();

require '../../../vendor/phpmailer/PHPMailer/src/Exception.php';
require '../../../vendor/phpmailer/PHPMailer/src/PHPMailer.php';
require '../../../vendor/phpmailer/PHPMailer/src/SMTP.php';
include_once '../../modelo/dao/pedidoDAO.php';
$config = include '../../config.php';

if (isset($_SESSION['sesion'])) {
    $sesion = $_SESSION['sesion'];

    $nombreCliente = $_POST['nombre_cliente'];
    $nomProducto = $_POST['nomProducto'];
    $emailCliente = $_POST['email_cliente'];

    $mail = new PHPMailer(true);
    $mail->setLanguage('es');

    date_default_timezone_set('America/Lima');
    $fechaActual = date('m/d/Y h:i:s a', time());
    $dao = new ClienteDAO();
    $cliente_id = $dao->obtenerIdCliente($sesion->usuario->getId());

    try {
        $dao = new PedidoDAO();
        $pedido = new Pedido();
        $pedido->setId_cliente($cliente_id);
        $pedido->setId_producto($_POST['producto_id']);
        $pedido->setFecha($fechaActual);
        $pedido->setEstado('Pendiente');
        $dao->agregarPedido($pedido);

        echo var_dump($pedido);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ventas.aemotos@gmail.com';
        $mail->Password = 'kgmspqugawfmfkqj';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ventas.aemotos@gmail.com', 'Andrés Espinoza Motos');
        $mail->addAddress($emailCliente, $nombreCliente);

        $mail->Subject = 'Confirmación de pedido';

        $mail->isHTML(true);
        $mail->Body = "
    <html>

    <head>
        <title>Confirmación de Pedido</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    </head>
    
    <body>
        <div class='container'>
            <div class='card text-center' style='border-radius: 1rem;'>
                <div class='card-body'>
                    <h5 class='alert alert-success card-title'>Hola $nombreCliente,</h5>
                    <p class='card-text'>Gracias por realizar tu pedido en Andrés Espinoza Motos. Aquí están los detalles de tu pedido:</p>
                    <p class='card-text'>Fecha: $fechaActual </p>
                    <p class='card-text'>Producto: $nomProducto </p>
                    <p class='card-text mt-4'>Nos comunicaremos contigo lo más pronto posible.</p>
                    <p class='alert alert-info mt-4'>¡Gracias por elegirnos!</p>
                </div>
            </div>
        </div>
    </body>
    
    </html>
";

        $mail->send();
        echo '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <title>Confirmación de Pedido</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    
    <body>
        <section class="vh-100">
            <div class="container-fluid">
                <div class="row d-flex h-100 align-items-center justify-content-center text-center">
                    <h5 class="alert alert-success">¡Gracias por tu pedido! Se ha enviado un correo de confirmación a ' . $emailCliente . '</h5>
                    <a href="../../vista/cliente/tienda.php" class="text-secondary">Regresar a la tienda</a>
                </div>
            </div>
        </section>
    </body>
    
    </html>';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    header("Location: ../../vista/cliente/tienda.php");
}
