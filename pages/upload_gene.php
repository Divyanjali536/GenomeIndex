<?php
session_start();
include("../includes/db.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gene = $_POST['gene'];
    $summary = $_POST['summary'];
    $chromosome = $_POST['chromosome'];
    $gene_type = $_POST['gene_type'];
    $gene_start = $_POST['gene_start'];
    $gene_end = $_POST['gene_end'];
    $gc_content = $_POST['gc_content'];
    $transcript_count = $_POST['transcript_count'];
    $ensembl_id = $_POST['ensembl_id'];
    $uniprot_id = $_POST['uniprot_id'];

    $stmt = $conn->prepare("INSERT INTO final_gene_info 
        (`gene_name`, `summary`, `chromosome`, `gene_type`, `gene_start`, `gene_end`, `gc_content`, `transcript_count`, `ensembl_id`, `uniprot_id`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiidiis", $gene, $summary, $chromosome, $gene_type, $gene_start, $gene_end, $gc_content, $transcript_count, $ensembl_id, $uniprot_id);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>✅ Gene data added successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Gene Data</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f7f8fa;
    margin: 0;
    padding: 0;
}
h2 {
    text-align: center;
    margin: 20px 0 30px;
    color: #333;
}
.form-container {
    width: 70%;
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.form-group {
    margin-bottom: 18px;
}
label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #444;
}
input[type="text"], input[type="number"], textarea {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #bbb;
    border-radius: 8px;
    box-sizing: border-box;
}
textarea {
    height: 120px;
    resize: vertical;
}

/* ✅ Updated button style to match search page */
.btn-submit {
    display: block;
    width: 100%;
    background: transparent;
    border: 2px solid #006d77;
    color: #006d77;
    font-size: 16px;
    font-weight: 500;
    padding: 12px 0;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 15px;
}
.btn-submit:hover {
    background-color: #006d77;
    color: white;
}

/* Back button - redirects to search page */
.back-link {
    position: absolute;
    top: 15px;
    left: 20px;
    text-decoration: none;
    background-color: transparent;
    border: 2px solid #006d77;
    color: #006d77;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 15px;
    transition: all 0.3s ease;
}
.back-link:hover {
    background-color: #006d77;
    color: white;
}
</style>
</head>
<body>
<!-- Back button redirects to search.php -->
<a href="search.php" class="back-link">⬅ Back</a>

<h2>➕ Add New Gene Information</h2>
<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label for="gene">Gene Name</label>
            <input type="text" id="gene" name="gene" required>
        </div>
        <div class="form-group">
            <label for="summary">Summary</label>
            <textarea id="summary" name="summary" required></textarea>
        </div>
        <div class="form-group">
            <label for="chromosome">Chromosome</label>
            <input type="text" id="chromosome" name="chromosome" required>
        </div>
        <div class="form-group">
            <label for="gene_type">Gene Type</label>
            <input type="text" id="gene_type" name="gene_type" required>
        </div>
        <div class="form-group">
            <label for="gene_start">Gene Start (bp)</label>
            <input type="number" id="gene_start" name="gene_start" required>
        </div>
        <div class="form-group">
            <label for="gene_end">Gene End (bp)</label>
            <input type="number" id="gene_end" name="gene_end" required>
        </div>
        <div class="form-group">
            <label for="gc_content">GC Content (%)</label>
            <input type="number" step="0.01" id="gc_content" name="gc_content" required>
        </div>
        <div class="form-group">
            <label for="transcript_count">Transcript Count</label>
            <input type="number" id="transcript_count" name="transcript_count" required>
        </div>
        <div class="form-group">
            <label for="ensembl_id">Ensembl ID</label>
            <input type="text" id="ensembl_id" name="ensembl_id" required>
        </div>
        <div class="form-group">
            <label for="uniprot_id">UniProt ID</label>
            <input type="text" id="uniprot_id" name="uniprot_id" required>
        </div>
        <button type="submit" class="btn-submit">Save Gene Data</button>
    </form>
</div>
</body>
</html>
