<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$revcomp = '';
if (isset($_POST['dna'])) {
    $dna = strtoupper(preg_replace('/[^ATGC]/', '', $_POST['dna']));
    $revcomp = strtr(strrev($dna), 'ATGC', 'TACG');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reverse Complement</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
body {
    font-family:'Segoe UI', sans-serif;
    background:#f7f8fa;
    display:flex;
    flex-direction:column;
    align-items:center;
    min-height:100vh;
}

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
}
.back-btn:hover { background:#006d77; color:white; }

.container { 
    margin-top:100px; 
    text-align:center; 
}

textarea {
    width:400px;
    height:150px;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    font-family:monospace;
}

button {
    padding:10px 20px;
    margin-top:10px;
    border:2px solid #006d77;
    background:transparent;
    color:#006d77;
    border-radius:6px;
    cursor:pointer;
    transition:all 0.3s ease;
}
button:hover { background:#006d77; color:white; }

/* Result box - centered and free width */
.result-box {
    margin: 20px auto;       /* center horizontally */
    padding: 20px;
    border: 2px solid #006d77;
    border-radius: 8px;
    background: white;
    width: auto;             /* free width */
    max-width: 90%;          /* prevent overflow */
    word-break: break-word;
    white-space: pre-wrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    font-family: monospace;
    color: #006d77;
    font-weight: 500;
    text-align: center;      /* center text inside box */
}
</style>
</head>
<body>

<a href="../tools.php" class="back-btn">← Back</a>

<div class="container">
    <h2>Reverse Complement</h2>
    <form method="POST">
        <textarea name="dna" placeholder="Enter DNA sequence here"><?php echo isset($_POST['dna']) ? htmlspecialchars($_POST['dna']) : ''; ?></textarea><br>
        <button type="submit">Get Reverse Complement</button>
    </form>

    <?php if($revcomp): ?>
    <div class="result-box">
        <strong>Reverse Complement:</strong><br>
        <?php echo $revcomp; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
