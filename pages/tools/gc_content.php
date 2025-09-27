<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$gc_content = '';
if (isset($_POST['dna'])) {
    $dna = strtoupper(preg_replace('/[^ATGC]/', '', $_POST['dna']));
    $length = strlen($dna);
    $gc_count = substr_count($dna, 'G') + substr_count($dna, 'C');
    $gc_content = $length > 0 ? round(($gc_count / $length) * 100, 2) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GC Content Calculator</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
body { font-family:'Segoe UI', sans-serif; background:#f7f8fa; display:flex; flex-direction:column; align-items:center; min-height:100vh; }
.back-btn { position:absolute; top:20px; left:20px; text-decoration:none; border:2px solid #006d77; color:#006d77; padding:8px 15px; border-radius:6px; transition:all 0.3s ease; }
.back-btn:hover { background:#006d77; color:white; }
.container { margin-top:100px; text-align:center; }
textarea { width:400px; height:150px; padding:10px; border-radius:6px; border:1px solid #ccc; }
button { padding:10px 20px; margin-top:10px; border:2px solid #006d77; background:transparent; color:#006d77; border-radius:6px; cursor:pointer; transition:all 0.3s ease; }
button:hover { background:#006d77; color:white; }
.result { margin-top:20px; font-weight:500; color:#006d77; }
</style>
</head>
<body>

<a href="../tools.php" class="back-btn">← Back</a>

<div class="container">
    <h2>GC Content Calculator</h2>
    <form method="POST">
        <textarea name="dna" placeholder="Enter DNA sequence here"><?php echo isset($_POST['dna']) ? htmlspecialchars($_POST['dna']) : ''; ?></textarea><br>
        <button type="submit">Calculate GC Content</button>
    </form>

    <?php if($gc_content !== ''): ?>
    <div class="result">
        <strong>GC Content:</strong> <?php echo $gc_content; ?>%
    </div>
    <?php endif; ?>
</div>

</body>
</html>
