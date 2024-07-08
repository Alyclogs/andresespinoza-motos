<?php
require '../../../vendor/autoload.php';

use Fpdf\Fpdf;
use Luecano\NumeroALetras\NumeroALetras;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $tipo_comprobante = $_POST['tipo_comprobante'];
    $clientedoc = $_POST['clientedoc'];
    $fecha = $_POST['fecha'];
    $vendedorId = $_POST['vendedorId'];
    $vendedorNombre = $_POST['vendedorNombre'];
    $productoId = $_POST['productoId'];
    $productoNombre = $_POST['productoNombre'];
    $clienteNombre = $_POST['clienteNombre'];
    $subtotal = $_POST['subtotal'];
    $descuento = $_POST['descuento'];
    $total = $subtotal - $descuento;

    // Datos de ejemplo
    $info = array(
        'id_venta' => trim($id),
        'fecha' => trim($fecha),
        'tipo-comprobante' => trim($tipo_comprobante),
        'dni_cliente' => trim($clientedoc),
        'nombre_cliente' => trim($clienteNombre),
        'descuento' => $descuento,
        'total_amt' => $total,
    );

    $productoInfo = array(
        'id' => trim($productoId),
        'nombre' => $productoNombre,
        'precio' => $subtotal
    );

    class PDF extends FPDF
    {
        function Header()
        {
            // Logo de la empresa
            $this->Image('../../../public/assets/img/logo-img-full.png', 10, 10, 30);

            // Título y datos de la empresa
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(190, 10, "ANDRÉS ESPINOZA MOTOS", 0, 1, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Cell(190, 7, "Direccion, Lima, Perú.", 0, 1, 'C');
            $this->Cell(190, 7, "RUC : 2060*********", 0, 1, 'C');

            // Línea separadora
            $this->Line(10, 47, 200, 47);
            $this->Ln(5); // Salto de línea adicional
        }

        function body($info, $products_info)
        {
            // Información del cliente y comprobante
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, "Entregado a: " . $info["nombre_cliente"], 0, 1);
            $this->Cell(0, 10, "DNI: " . $info["dni_cliente"], 0, 1);
            $this->Cell(0, 10, $info["tipo-comprobante"] . " N°: " . $info["id_venta"], 0, 1, "R");
            $this->Cell(0, 10, "Fecha: " . $info["fecha"], 0, 1, "R");
            $this->Ln(5);

            // Detalles de los productos
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(80, 10, "DESCRIPCION", 1, 0, "C");
            $this->Cell(40, 10, "PRECIO", 1, 0, "C");
            $this->Cell(30, 10, "CANTIDAD", 1, 0, "C");
            $this->Cell(40, 10, "TOTAL", 1, 1, "C");

            $this->SetFont('Arial', '', 12);
            $this->Cell(80, 10, $products_info["nombre"], 1);
            $this->Cell(40, 10, "S/." . number_format($products_info["precio"], 2), 1, 0, "R");
            $this->Cell(30, 10, "1", 1, 0, "C");
            $this->Cell(40, 10, "S/." . number_format($products_info["precio"], 2), 1, 1, "R");

            // Subtotal, descuento y total
            $this->Cell(150, 10, "SUBTOTAL", 1, 0, "R");
            $this->Cell(40, 10, "S/." . number_format($products_info["precio"], 2), 1, 1, "R");

            $this->Cell(150, 10, "DESCUENTO", 1, 0, "R");
            $this->Cell(40, 10, "S/." . number_format($info["descuento"], 2), 1, 1, "R");

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(150, 10, "TOTAL", 1, 0, "R");
            $this->Cell(40, 10, "S/." . number_format($info["total_amt"], 2), 1, 1, "R");

            // Total en palabras
            $formatter = new NumeroALetras();
            $this->Ln(5);
            $this->Cell(0, 10, "Son: " . $formatter->toMoney($info["total_amt"], 2, 'Soles', 'Céntimos'), 0, 1);
            $this->Ln(10); // Espacio adicional
        }

        function Footer()
        {
            $this->SetY(-50);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, "por ANDRÉS ESPINOZA MOTOS", 0, 1, "R");
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, "Authorized Signature", 0, 1, "R");
            $this->Cell(0, 10, "Este es un comprobante generado digitalmente", 0, 1, "C");
        }
    }

    // Crear el PDF
    ob_start();
    $pdf = new PDF("P", "mm", "A4");
    $pdf->AddPage();
    $pdf->body($info, $productoInfo);

    // Salida del PDF
    $pdf->Output();
    ob_end_flush();
}
