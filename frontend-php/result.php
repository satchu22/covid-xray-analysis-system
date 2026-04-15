<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$patient_name = trim($_POST['patient_name'] ?? '');

if ($patient_name === '') {
    die('Patient name is required.');
}

if (!isset($_FILES['xray_image']) || $_FILES['xray_image']['error'] !== UPLOAD_ERR_OK) {
    die('Image upload failed. Please try again.');
}

$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
$originalName = basename($_FILES['xray_image']['name']);
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($extension, $allowedExtensions)) {
    die('Invalid image format. Please upload JPG, JPEG, PNG, or WEBP.');
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filename = time() . '_' . uniqid('xray_', true) . '.' . $extension;
$absolutePath = $uploadDir . $filename;
$relativePath = 'uploads/' . $filename;

if (!move_uploaded_file($_FILES['xray_image']['tmp_name'], $absolutePath)) {
    die('Failed to save the uploaded image.');
}

// Call Python API
$pythonApiUrl = 'http://127.0.0.1:5001/predict';
$cfile = new CURLFile(realpath($absolutePath));
$postData = ['image' => $cfile];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $pythonApiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    curl_close($ch);
    die('Python ML service is not running or is unreachable.');
}
curl_close($ch);

if ($httpCode !== 200) {
    die('The ML service returned an error.');
}

$result = json_decode($response, true);
if (!$result || !isset($result['prediction'])) {
    die('Invalid response from the ML service.');
}

$prediction = $result['prediction'];
$confidence = floatval($result['confidence'] ?? 0);
$severity_score = floatval($result['severity_score'] ?? 0);
$notes = $result['notes'] ?? 'Educational demo output';

// Save to JSON instead of database
$dataFile = __DIR__ . '/data.json';

$newEntry = [
    'patient_name' => $patient_name,
    'image_path' => $relativePath,
    'prediction' => $prediction,
    'confidence' => $confidence,
    'severity_score' => $severity_score,
    'notes' => $notes,
    'created_at' => date('Y-m-d H:i:s')
];

if (file_exists($dataFile)) {
    $existingData = json_decode(file_get_contents($dataFile), true);
    if (!is_array($existingData)) {
        $existingData = [];
    }
} else {
    $existingData = [];
}

$existingData[] = $newEntry;
file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

$isPositive = strtolower($prediction) === 'covid positive';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis Result</title>
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
<section class="result-layout">

    <div class="result-image-card">
        <h2>Uploaded X-ray</h2>
        <img class="result-image" src="<?php echo htmlspecialchars($relativePath); ?>" alt="Uploaded X-ray">
    </div>

    <div class="result-card">
        <h2>Analysis result</h2>

        <div class="result-row">
            <strong>Patient Name:</strong>
            <?php echo htmlspecialchars($patient_name); ?>
        </div>

        <div class="result-row">
            <strong>Prediction:</strong>
            <span style="color: <?php echo $isPositive ? 'red' : 'green'; ?>;">
                <?php echo htmlspecialchars($prediction); ?>
            </span>
        </div>

        <div class="result-row">
            <strong>Confidence:</strong>
            <?php echo number_format($confidence, 2); ?>%
        </div>

        <div class="result-row">
            <strong>Severity Score:</strong>
            <?php echo number_format($severity_score, 2); ?>/100
        </div>

        <div class="result-row">
            <strong>Date:</strong>
            <?php echo date('Y-m-d H:i:s'); ?>
        </div>

        <div class="result-row">
            <strong>Note:</strong>
            <?php echo htmlspecialchars($notes); ?>
        </div>

        <br>

        <a href="index.php">Analyze Another</a> |
        <a href="history.php">View History</a>
    </div>

</section>
</main>

</body>
</html>