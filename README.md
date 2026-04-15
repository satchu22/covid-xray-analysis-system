# COVID-19 Chest X-Ray Analysis System

A polished **bachelor’s project** demonstrating the integration of machine learning with a full-stack web application for medical image analysis.

This system allows users to upload chest X-ray images, analyze them using a Python-based ML service, and view predictions through a clean web interface.

> ⚠️ Academic use only: This project is for educational purposes and is NOT a medical diagnosis tool.

---

## 🧠 Tech Stack

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **ML Service:** Python (Flask + TensorFlow pipeline)  
- **Storage:** JSON file (lightweight local storage)

---

## 🚀 Features

- Upload chest X-ray image  
- Enter patient name  
- Predict **COVID Positive / Negative**  
- Display confidence score  
- Display **lung involvement (severity score)**  
- Save results locally  
- View analysis history  
- Clean UI for final-year project demo  

---

## 📁 Project Structure
covid_xray_bachelors_project/
│
├── frontend-php/
│ ├── index.php
│ ├── result.php
│ ├── history.php
│ ├── style.css
│ ├── script.js
│ └── uploads/
│
├── ml-service/
│ ├── app.py
│ ├── utils.py
│ ├── train_fast.py
│ ├── requirements.txt
│ ├── model.h5 (generated after training)
│ └── dataset/ (not included)
│
└── README.md

## Quick Setup

### 1) Import database
Create a MySQL database and table by running:

```sql
SOURCE database/schema.sql;
```

Or paste the SQL contents into phpMyAdmin.

### 2) Configure PHP database connection
Open:

```text
frontend-php/db.php
```

Update these values if needed:

- host
- username
- password
- database name

### 3) Start the Python ML service

```bash
cd ml-service
pip install -r requirements.txt
python app.py
```

The API will run at:

```text
http://127.0.0.1:5001
```

### 4) Start the PHP frontend
If you are using XAMPP or MAMP:

- Place `frontend-php` inside your web root:
  - XAMPP: `htdocs/`
  - MAMP: `htdocs/`

Then open:

```text
http://localhost/frontend-php/index.php
```

## Important Note About the Model

This project includes a **fallback demo prediction mode** so the application can still run even if you have not trained a real model yet.

### How fallback mode works
If no trained model file exists, the Python service:
- computes a grayscale/contrast-based opacity score
- generates a reasonable educational demo response
- returns JSON in the same format as a trained model

### How to use a real model
Train a model and place it at:

```text
ml-service/saved_models/covid_xray_model.keras
```

Then restart the Flask service.

## Recommended Dataset Sources for Academic Work

Use public educational chest X-ray datasets from trusted sources and clearly cite them in your report.

## Suggested Title

**COVID-19 Chest X-Ray Classification and Analysis System Using Machine Learning**

## Resume Description

Built a full-stack medical imaging demo application using **HTML, CSS, JavaScript, PHP, MySQL, and Python** that allows users to upload chest X-ray images and patient details, runs image inference through a Python ML service, predicts COVID positive/negative status with confidence scoring, computes an educational lung opacity severity score, and stores analysis records with timestamp in a relational database.

## Viva Explanation

- User uploads patient name and chest X-ray through the PHP frontend
- PHP stores the image and sends it to the Flask-based Python API
- Python preprocesses the image and either:
  - uses a trained CNN model, or
  - uses the built-in fallback demo pipeline
- The prediction, confidence, and severity score are returned as JSON
- PHP stores the record in MySQL
- A polished result page and history dashboard present the output
