
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Chest X-Ray Analysis System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div class="brand">COVID-19 Chest X-Ray Analysis System</div>
        <nav class="nav-links">
            <a href="index.php" class="active">Home</a>
            <a href="history.php">History</a>
        </nav>
    </header>

    <main class="page-shell">
        <section class="hero-card">
            <div class="hero-copy">
                <span class="badge">Bachelor's Project</span>
                <h1>AI-assisted chest X-ray screening demo</h1>
                <p>
                    Upload a patient’s chest X-ray image, analyze it through a Python-based machine learning service,
                    and store the result securely in a MySQL database through a PHP backend.
                </p>

                <div class="hero-points">
                    <div class="point-card">
                        <h3>Frontend</h3>
                        <p>HTML, CSS, JavaScript</p>
                    </div>
                    <div class="point-card">
                        <h3>Backend</h3>
                        <p>PHP + MySQL</p>
                    </div>
                    <div class="point-card">
                        <h3>Machine Learning</h3>
                        <p>Python + Flask</p>
                    </div>
                </div>
            </div>

            <div class="hero-art">
                <img src="assets/placeholder.svg" alt="Chest X-ray illustration">
            </div>
        </section>

        <section class="form-card">
            <div class="section-header">
                <div>
                    <h2>Upload X-ray for analysis</h2>
                    <p>Educational machine learning workflow for academic demonstration.</p>
                </div>
            </div>

            <form action="result.php" method="POST" enctype="multipart/form-data" id="uploadForm" class="upload-form">
                <div class="form-grid">
                    <div class="field">
                        <label for="patient_name">Patient Name</label>
                        <input
                            type="text"
                            name="patient_name"
                            id="patient_name"
                            placeholder="Enter full name"
                            required
                            minlength="2"
                            maxlength="100"
                        >
                    </div>

                    <div class="field">
                        <label for="xray_image">Chest X-ray Image</label>
                        <input
                            type="file"
                            name="xray_image"
                            id="xray_image"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >
                    </div>
                </div>

                <div class="preview-panel">
                    <div class="preview-frame">
                        <img id="preview" src="assets/placeholder.svg" alt="Image preview">
                    </div>
                    <div class="preview-meta">
                        <h3>Preview</h3>
                        <p id="fileMeta">No image selected yet.</p>
                        <ul class="mini-list">
                            <li>Allowed formats: JPG, JPEG, PNG, WEBP</li>
                            <li>Recommended image: clear frontal chest X-ray</li>
                            <li>Output includes prediction, confidence, and severity score</li>
                        </ul>
                    </div>
                </div>

                <div class="notice">
                    <strong>Project note:</strong>
                    This is an academic demonstration system and should not be used for real clinical diagnosis.
                </div>

                <div class="actions-row">
                    <button type="submit" class="primary-btn">Analyze X-ray</button>
                    <a href="history.php" class="secondary-btn">View Saved History</a>
                </div>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
