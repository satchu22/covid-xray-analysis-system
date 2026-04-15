CREATE DATABASE IF NOT EXISTS covid_xray_db;
USE covid_xray_db;

CREATE TABLE IF NOT EXISTS analyses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    prediction VARCHAR(50) NOT NULL,
    confidence DECIMAL(5,2) NOT NULL,
    severity_score DECIMAL(5,2) NOT NULL,
    notes VARCHAR(255) DEFAULT 'Educational demo output',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
