<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gene Tools</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body { 
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    background:#f7f8fa; 
    display:flex; 
    flex-direction:column; 
    align-items:center; 
    min-height:100vh; 
    margin:0;
    padding-bottom:50px;
}

/* Back Button */
.back-btn { 
    position:absolute; 
    top:20px; 
    left:20px; 
    text-decoration:none; 
    border:2px solid #006d77; 
    color:#006d77; 
    padding:8px 15px; 
    border-radius:6px; 
    transition:all 0.3s ease; 
    font-size:15px;
}
.back-btn:hover { 
    background:#006d77; 
    color:white; 
}

/* Title */
h1 { 
    margin-top:100px; 
    color:#006d77; 
    text-align:center; 
}

/* Tools Grid */
.tools-grid { 
    display:grid; 
    grid-template-columns:repeat(3, 1fr); 
    gap:25px; 
    margin-top:50px; 
    width:90%; 
    max-width:900px; 
}

/* Second row container to center 2 cards */
.second-row {
    grid-column: 1 / 4; /* span full width of 3 columns */
    display:flex;
    justify-content:center;
    gap:25px;
}

/* Tool Card */
.tool-card { 
    background:white; 
    border:2px solid #006d77; 
    border-radius:12px; 
    padding:25px 15px; 
    text-align:center; 
    transition:all 0.3s ease; 
    cursor:pointer; 
    text-decoration:none; 
    color:#006d77; 
    font-weight:600; 
    font-size:16px;
    min-height:100px;
    width:220px; /* fixed width for uniform size */
    display:flex;
    justify-content:center;
    align-items:center;
}
.tool-card:hover { 
    background:#006d77; 
    color:white; 
}
</style>
</head>
<body>

<a href="search.php" class="back-btn">← Back</a>

<h1>Gene Tools Dashboard</h1>

<div class="tools-grid">
    <!-- First row: 3 tools -->
    <a href="tools/translate_dna.php" class="tool-card">Translate DNA → Protein</a>
    <a href="tools/reverse_complement.php" class="tool-card">Reverse Complement</a>
    <a href="tools/gc_content.php" class="tool-card">GC Content Calculator</a>

    <!-- Second row: 2 tools centered -->
    <div class="second-row">
        <a href="tools/compare_genes.php" class="tool-card">Compare Gene Sequences</a>
        <a href="tools/reactome.php" class="tool-card">Reactome Pathways</a>
    </div>
</div>

</body>
</html>
