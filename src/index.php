<?php
include ('config/db.php');


$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<h1>PHP + Docker</h1>
<p>Tabelas no banco:</p>
<ul>
<?php foreach ($tables as $table): ?>
    <li><?= $table ?></li>
<?php endforeach; ?>
</ul>
