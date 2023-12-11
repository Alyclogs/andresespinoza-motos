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
    $total = $_POST['total'];

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

            $this->SetFont('Arial', 'B', 14);
            $this->Cell(50, 10, "ANDRÉS ESPINOZA MOTOS", 0, 1);
            $this->SetFont('Arial', '', 14);
            $this->Cell(50, 7, "Direccion,", 0, 1);
            $this->Cell(50, 7, "Lima, Perú.", 0, 1);
            $this->Cell(50, 7, "RUC : 2060*********", 0, 1);

            $this->SetY(15);
            $this->SetX(-90);
            $this->SetFont('Arial', 'B', 17);
            $this->Cell(60, 10, "COMPROBANTE DE PAGO", 0, 1);

            $this->Line(0, 48, 210, 48);
        }

        function body($info, $products_info)
        {
            $this->SetY(55);
            $this->SetX(10);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(50, 10, "Entregado a: ", 0, 1);
            $this->SetFont('Arial', '', 12);
            $this->Cell(50, 7, $info["dni_cliente"], 0, 1);
            $this->Cell(50, 7, $info["nombre_cliente"], 0, 1);

            $this->SetY(55);
            $this->SetX(-60);
            $this->SetFont('Arial', '', 12);
            $this->Cell(50, 7, $info["tipo-comprobante"] . " N°: " . $info["id_venta"], 0, 0, "R");

            $this->SetY(63);
            $this->SetX(-60);
            $this->Cell(50, 7, "Fecha: " . $info["fecha"], 0, 0, "R");

            $this->SetY(95);
            $this->SetX(10);
            $this->SetFont('Arial', 'B', 12);

            $this->Cell(80, 9, "DESCRIPCION", 1, 0, "C");
            $this->Cell(40, 9, "PRECIO", 1, 0, "C");
            $this->Cell(30, 9, "CANTIDAD", 1, 0, "C");
            $this->Cell(40, 9, "TOTAL", 1, 1, "C");

            $this->SetFont('Arial', '', 12);

            $this->Cell(80, 9, $products_info["nombre"], "LR");
            $this->Cell(40, 9, "S/." . number_format($products_info["precio"], 2), "R", 0, "R");
            $this->Cell(30, 9, "1", "R", 0, "C");
            $this->Cell(40, 9, "S/." . number_format($products_info["precio"], 2), "R", 1, "R");

            $this->Cell(80, 9, "", "LR");
            $this->Cell(40, 9, "", "R", 0, "R");
            $this->Cell(30, 9, "", "R", 0, "C");
            $this->Cell(40, 9, "", "R", 1, "R");

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(150, 9, "SUBTOTAL", 1, 0, "R");
            $this->Cell(40, 9, "S/." . number_format($products_info["precio"], 2), 1, 1, "R");

            $this->Cell(110, 9, "", 0, 0, "C");
            $this->Cell(40, 9, "DESCUENTO", 1, 0, "R");
            $this->Cell(40, 9, "S/." . number_format($info["descuento"], 2), 1, 1, "R");

            $this->Cell(110, 9, "", 0, 0, "C");
            $this->Cell(40, 9, "TOTAL", 1, 0, "R");
            $this->Cell(40, 9, "S/." . number_format($info["total_amt"], 2), 1, 1, "R");

            $formatter = new NumeroALetras();

            $this->SetY(165);
            $this->SetX(10);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 9, "Son:", 0, 1);
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 9, $formatter->toMoney($info["total_amt"], 2, 'Soles', 'Céntimos'), 0, 1);
        }
        function Footer()
        {
            $this->SetY(-50);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, "por ANDRÉS ESPINOZA MOTOS", 0, 1, "R");
            $this->Ln(15);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, "Authorized Signature", 0, 1, "R");
            $this->SetFont('Arial', '', 10);

            $this->Cell(0, 10, "Este es un comprobante generado digitalmente", 0, 1, "C");
        }
    }

    ob_start();
    $pdf = new PDF("P", "mm", "A4");
    $pdf->AddPage();
    $pdf->body($info, $productoInfo);

    $pdf->Output();
    ob_end_flush();
}
