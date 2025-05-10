<?php
require('fpdf/fpdf.php');

// Create PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Sales Transactions', 0, 1, 'C');
$pdf->Ln(10);

// Set font for table
$pdf->SetFont('Arial', '', 12);

$conn = new mysqli("localhost", "root", "", "iwb_re");
if ($conn->connect_error) {
    $pdf->Cell(0, 10, 'Database connection failed.', 0, 1);
} else {
    $result = $conn->query("SELECT sale_id, amount, sale_date FROM sales");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $text = "Order #{$row['sale_id']} - \${$row['amount']} - {$row['sale_date']}";
            $pdf->Cell(0, 10, $text, 0, 1);
        }
    } else {
        $pdf->Cell(0, 10, 'No sales records found.', 0, 1);
    }
}

$pdf->Output('D', 'Sales_Transactions.pdf'); // 'D' forces download
?>
