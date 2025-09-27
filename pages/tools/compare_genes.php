<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$comparison = '';
if (isset($_POST['seq1'], $_POST['seq2'])) {
    $seq1 = strtoupper(preg_replace('/[^ATGC]/', '', $_POST['seq1']));
    $seq2 = strtoupper(preg_replace('/[^ATGC]/', '', $_POST['seq2']));
    $length = min(strlen($seq1), strlen($seq2));
    $matches = 0;
    for ($i=0; $i<$length; $i++) {
        if ($seq1[$i] === $seq2[$i]) $matches++;
    }
    $comparison = $length > 0 ? round(($matches / $length) * 100, 2) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Compare Gene Sequences</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
body { font-family:'Segoe UI', sans-serif; background:#f7f8fa; display:flex; flex-direction:column; align-items:center; min-height:100vh; }
.back-btn { position:absolute; top:20px; left:20px; text-decoration:none; border:2px solid #006d77; color:#006d77; padding:8px 15px; border-radius:6px; transition:all 0.3s ease; }
.back-btn:hover { background:#006d77; color:white; }
.container { margin-top:100px; text-align:center; }
textarea { width:400px; height:120px; padding:10px; border-radius:6px; border:1px solid #ccc; margin-bottom:10px; }
button { padding:10px 20px; border:2px solid #006d77; background:transparent; color:#006d77; border-radius:6px; cursor:pointer; transition:all 0.3s ease; }
button:hover { background:#006d77; color:white; }
.result { margin-top:20px; font-weight:500; color:#006d77; }
</style>
</head>
<body>

<a href="../tools.php" class="back-btn">← Back</a>

<div class="container">
    <h2>Compare Gene Sequences</h2>
    <form method="POST">
        <textarea name="seq1" placeholder="Enter first DNA sequence"><?php echo isset($_POST['seq1']) ? htmlspecialchars($_POST['seq1']) : ''; ?></textarea><br>
        <textarea name="seq2" placeholder="Enter second DNA sequence"><?php echo isset($_POST['seq2']) ? htmlspecialchars($_POST['seq2']) : ''; ?></textarea><br>
        <button type="submit">Compare</button>
    </form>

    <?php if($comparison !== ''): ?>
    <div class="result">
        <strong>Similarity:</strong> <?php echo $comparison; ?>%
    </div>
    <?php endif; ?>
</div>

</body>
</html>
