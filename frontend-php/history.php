<?php
$dataFile = __DIR__ . '/data.json';

$rows = [];

if (file_exists($dataFile)) {
    $rows = json_decode(file_get_contents($dataFile), true);
    if (!is_array($rows)) {
        $rows = [];
    }
}

$rows = array_reverse($rows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <div class="brand">COVID-19 Chest X-Ray Analysis System</div>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="history.php">History</a>
    </nav>
</header>

<main class="page-shell narrow-shell">
    <div class="result-card">
        <h2>Analysis History</h2>

        <?php if (empty($rows)): ?>
            <p>No records found.</p>
        <?php else: ?>
            <table border="1" cellpadding="10" cellspacing="0" style="width:100%; margin-top:20px; background:#fff; color:#000;">
                <tr>
                    <th>Patient Name</th>
                    <th>Prediction</th>
                    <th>Confidence</th>
                    <th>Severity</th>
                    <th>Date</th>
                </tr>

                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['prediction']); ?></td>
                        <td><?php echo number_format($row['confidence'], 2); ?>%</td>
                        <td><?php echo number_format($row['severity_score'], 2); ?>/100</td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <br>
        <a href="index.php">Back to Home</a>
    </div>
</main>

</body>
</html>