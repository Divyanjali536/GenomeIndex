<?php
// FPDF + DB
require_once __DIR__ . '/../includes/fpdf/fpdf.php';
require_once __DIR__ . '/../includes/db.php';

// Accept either ?gene= or ?query= for flexibility
$param = '';
if (isset($_GET['gene']) && trim($_GET['gene']) !== '') {
    $param = trim($_GET['gene']);
} elseif (isset($_GET['query']) && trim($_GET['query']) !== '') {
    $param = trim($_GET['query']);
} else {
    die("Invalid request. No gene specified.");
}

// If numeric, also try as id
$idParam = ctype_digit($param) ? (int)$param : 0;

// Fetch record
$sql = "SELECT
            id,
            `Gene`,
            `Summary`,
            `Chromosome`,
            `Gene type`,
            `Gene start (bp)`,
            `Gene end (bp)`,
            `Gene % GC content`,
            `Transcript count`,
            `Ensembl_ID`,
            `UniProt_ID`
        FROM final_gene_info
        WHERE `Gene` = ? OR id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $param, $idParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    die("No results found for: " . htmlspecialchars($param));
}
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

/**
 * Helper: draw a 2-column row with a MultiCell on the right (wraps long text like Summary)
 */
class PDF_Table extends FPDF {
    function RowKV($label, $value) {
        // Label cell (fixed width)
        $labelWidth = 60;
        $valueWidth = 130;

        // Save current position
        $x = $this->GetX();
        $y = $this->GetY();

        // Draw label cell
        $this->SetFont('Arial', 'B', 11);
        $this->MultiCell($labelWidth, 8, $label, 1, 'L');

        // Move to the right of the label, reset Y to original top of row
        $this->SetXY($x + $labelWidth, $y);

        // Draw value cell (wrap)
        $this->SetFont('Arial', '', 11);
        $this->MultiCell($valueWidth, 8, (string)$value, 1, 'L');

        // After MultiCell, cursor is already at next line start
    }
}

// Build PDF
$pdf = new PDF_Table();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$title = 'Gene Details';
if (!empty($row['Gene'])) {
    $title .= ' — ' . $row['Gene'];
}
$pdf->Cell(0, 10, $title, 0, 1, 'C');
$pdf->Ln(4);

// Output rows
$pdf->RowKV('ID', $row['id']);
$pdf->RowKV('Gene', $row['Gene']);
$pdf->RowKV('Summary', $row['Summary']);
$pdf->RowKV('Chromosome', $row['Chromosome']);
$pdf->RowKV('Gene Type', $row['Gene type']);
$pdf->RowKV('Gene Start (bp)', $row['Gene start (bp)']);
$pdf->RowKV('Gene End (bp)', $row['Gene end (bp)']);
$pdf->RowKV('GC Content (%)', $row['Gene % GC content']);
$pdf->RowKV('Transcript Count', $row['Transcript count']);
$pdf->RowKV('Ensembl ID', $row['Ensembl_ID']);
$pdf->RowKV('UniProt ID', $row['UniProt_ID']);

// Download
$filename = 'Gene_Details';
if (!empty($row['Gene'])) {
    $filename .= '_' . preg_replace('/[^A-Za-z0-9_\-]+/', '_', $row['Gene']);
}
$filename .= '.pdf';
$pdf->Output('D', $filename);
