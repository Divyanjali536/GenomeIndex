<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['gene'])) {
    $gene = strtoupper(trim($_POST['gene']));
    $reactome_url = "https://reactome.org/PathwayBrowser/#/DTAB=AT&AN={$gene}";
    header("Location: $reactome_url");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reactome Pathways</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
body { font-family:'Segoe UI', sans-serif; background:#f7f8fa; display:flex; flex-direction:column; align-items:center; min-height:100vh; }
.back-btn { position:absolute; top:20px; left:20px; text-decoration:none; border:2px solid #006d77; color:#006d77; padding:8px 15px; border-radius:6px; transition:all 0.3s ease; }
.back-btn:hover { background:#006d77; color:white; }
.container { margin-top:100px; text-align:center; }
input[type="text"] { padding:10px; width:300px; border-radius:6px; border:1px solid #ccc; }
button { padding:10px 20px; margin-left:10px; border:2px solid #006d77; background:transparent; color:#006d77; border-radius:6px; cursor:pointer; transition:all 0.3s ease; }
button:hover { background:#006d77; color:white; }
</style>
</head>
<body>

<a href="../tools.php" class="back-btn">← Back</a>

<div class="container">
    <h2>Reactome Pathways</h2>
    <form method="POST">
        <input type="text" name="gene" placeholder="Enter Gene Symbol" required>
        <button type="submit">Search Pathways</button>
    </form>
</div>

</body>
</html>
