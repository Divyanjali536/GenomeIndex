<?php
session_start();
include("../includes/db.php");

// Check if "query" is passed in the URL
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $queryParam = trim($_GET['query']);
} else {
    die("Invalid request. No gene specified.");
}

// SQL query
$query = "SELECT 
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

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $queryParam, $queryParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("No results found for: " . htmlspecialchars($queryParam));
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gene Details</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f7f8fa;
    min-height: 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Back button top-left */
.back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    text-decoration: none;
    background-color: transparent;
    border: 2px solid #006d77;
    color: #006d77;
    padding: 8px 15px;
    border-radius: 6px;
    font-size: 15px;
    transition: all 0.3s ease;
}
.back-btn:hover {
    background-color: #006d77;
    color: white;
}

/* Top-right buttons like search page */
.top-nav {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
}

/* Rectangular buttons for Upload New Gene & Tools */
.rect-btn {
    display: inline-block;
    padding: 8px 14px;
    background-color: transparent; /* outlined style */
    border: 2px solid #006d77;
    color: #006d77;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.rect-btn:hover {
    background-color: #006d77;
    color: white;
}

/* Profile button (oval) outlined by default */
.profile-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background-color: transparent; /* transparent by default */
    border: 2px solid #006d77;
    color: #006d77;
    border-radius: 50px;
    text-decoration: none;
    font-size: 18px;
    transition: all 0.3s ease;
}
.profile-btn:hover {
    background-color: #006d77;
    color: white;
}
.profile-btn svg {
    width: 20px;
    height: 20px;
    fill: currentColor;
}

h2 {
    text-align: center;
    margin-top: 80px;
}

table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
    font-size: 16px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
th, td {
    border: 1px solid #ddd;
    padding: 12px 10px;
    text-align: left;
}
th {
    background-color: #006d77;
    color: white;
}

.download-btn {
    text-align: center;
    margin: 20px 0;
}
.download-btn a {
    text-decoration: none;
    padding: 10px 15px;
    background: #006d77;
    color: #fff;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.download-btn a:hover {
    background: #004f52;
}
</style>
</head>
<body>

<!-- Back Button -->
<a href="search.php" class="back-btn">← Back</a>

<!-- Top-right Buttons -->
<div class="top-nav">
    <a href="upload_new_gene.php" class="rect-btn">Upload New Gene</a>
    <a href="tools.php" class="rect-btn">Tools</a>
    <a href="profile.php" class="profile-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        </svg>
    </a>
</div>

<h2>Gene Details</h2>

<table>
    <tr><th>Gene</th><td><?php echo htmlspecialchars($row['Gene']); ?></td></tr>
    <tr><th>Summary</th><td><?php echo htmlspecialchars($row['Summary']); ?></td></tr>
    <tr><th>Chromosome</th><td><?php echo htmlspecialchars($row['Chromosome']); ?></td></tr>
    <tr><th>Gene Type</th><td><?php echo htmlspecialchars($row['Gene type']); ?></td></tr>
    <tr><th>Transcript Count</th><td><?php echo htmlspecialchars($row['Transcript count']); ?></td></tr>
    <tr><th>Start (bp)</th><td><?php echo htmlspecialchars($row['Gene start (bp)']); ?></td></tr>
    <tr><th>End (bp)</th><td><?php echo htmlspecialchars($row['Gene end (bp)']); ?></td></tr>
    <tr><th>GC Content</th><td><?php echo htmlspecialchars($row['Gene % GC content']); ?>%</td></tr>
    <tr><th>Ensembl ID</th><td><?php echo htmlspecialchars($row['Ensembl_ID']); ?></td></tr>
    <tr><th>UniProt ID</th><td><?php echo htmlspecialchars($row['UniProt_ID']); ?></td></tr>
</table>

<div class="download-btn">
    <a href="download_pdf.php?gene=<?php echo urlencode($row['Gene']); ?>">⬇ Download as PDF</a>
</div>

</body>
</html>
