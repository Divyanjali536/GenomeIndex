<?php
// Include DB connection
include("../includes/db.php");
include("../includes/pdf2text.php"); // our manual PDF reader

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['gene_file']) && $_FILES['gene_file']['error'] == 0) {
        $fileTmpPath = $_FILES['gene_file']['tmp_name'];
        $fileName = $_FILES['gene_file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $extractedText = '';

        if ($fileExtension === 'txt') {
            // For text files
            $extractedText = file_get_contents($fileTmpPath);

        } elseif ($fileExtension === 'docx') {
            // For Word .docx files
            $zip = new ZipArchive;
            if ($zip->open($fileTmpPath) === true) {
                $xmlIndex = 'word/document.xml';
                $text = $zip->getFromName($xmlIndex);
                $zip->close();
                $extractedText = strip_tags($text);
            }

        } elseif ($fileExtension === 'pdf') {
            // For PDF files
            $extractedText = pdf2text($fileTmpPath);

        } else {
            die("Unsupported file type: " . htmlspecialchars($fileExtension));
        }

        // Example: store into DB (assuming 'Gene' and 'Summary' exist in table)
        if (!empty(trim($extractedText))) {
            $stmt = $conn->prepare("INSERT INTO final_gene_info (`Gene`, `Summary`) VALUES (?, ?)");
            $geneName = substr($fileName, 0, strpos($fileName, '.')); // derive gene name from file
            $summary = substr($extractedText, 0, 500); // take first 500 chars
            $stmt->bind_param("ss", $geneName, $summary);
            $stmt->execute();
            $stmt->close();

            echo "<p>✅ File uploaded and data inserted successfully!</p>";
        } else {
            echo "<p>⚠ Could not extract text from file.</p>";
        }

    } else {
        echo "<p>⚠ No file uploaded or upload error occurred.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Gene File</title>
</head>
<body>
    <h2>Upload Gene Document (TXT, DOCX, PDF)</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="gene_file" required>
        <button type="submit">Upload & Save</button>
    </form>
</body>
</html>
