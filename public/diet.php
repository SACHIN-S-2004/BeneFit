<?php
include "includes/db.php";

require_once "includes/auth.php";
require_auth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BeneFit</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/dietStyle.css">
</head>

<body>

  <div class="ambient-light light-1"></div>
  <div class="ambient-light light-2"></div>

  <nav class="navbar navbar-expand-lg px-4 py-3">
    <div class="container-fluid">
      <a class="navbar-brand fs-4" href="dashboard.php">
        <i class="bi bi-robot me-2"></i>BeneFit
      </a>
      <div class="ms-auto d-flex align-items-center gap-3">
        <button onclick="toggleTheme()" class="btn btn-outline-glass rounded-circle p-2" style="width: 42px; height: 42px;">
          <i class="bi bi-moon-stars-fill"></i>
        </button>
        <a href="dashboard.php" class="btn btn-outline-glass rounded-pill px-4">Dashboard</a>
        <a href="logout.php" class="btn btn-danger rounded-pill px-4 fw-bold">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="glass-card mx-auto" style="max-width: 900px;">
      
      <div class="text-center mb-5">
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2 mb-3">
            <i class="bi bi-magic me-1"></i> AI Powered Analysis
          </span>
          <h2 class="fw-bold display-6 mb-2">Configure Your Plan</h2>
          <p class="text-muted">Enter your biometrics below. Our algorithm adapts to over 50 health markers.</p>
      </div>

      <form method="POST" action="result.php" id="dietForm" novalidate>
        
        <div class="row g-5">
            <div class="col-lg-6">
                <h5 class="section-title">Physical Metrics</h5>
                
                <div class="mb-3">
                    <label class="form-label">Age</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-calendar3"></i></span>
                        <input type="number" name="age" id="age" class="form-control rounded-end-3" placeholder="e.g. 25" min="1" max="120" required>
                    </div>
                    <small class="text-muted">Valid range: 1-120 years</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-gender-ambiguous"></i></span>
                        <select name="gender" class="form-select rounded-end-3" style="border-left:none;">
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Height (cm)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-rulers"></i></span>
                        <input type="number" step="0.1" id="height" name="height" class="form-control rounded-end-3" placeholder="e.g. 175" min="50" max="250" required>
                    </div>
                    <small class="text-muted">Valid range: 50-250 cm</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Weight (kg)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-person-standing"></i></span>
                        <input type="number" step="0.1" id="weight" name="weight" class="form-control rounded-end-3" placeholder="e.g. 70" min="20" max="300" required>
                    </div>
                    <small class="text-muted">Valid range: 20-300 kg</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Activity Level</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-activity"></i></span>
                        <select name="activity" class="form-select rounded-end-3" style="border-left:none;">
                            <option>Sedentary</option>
                            <option>Moderate</option>
                            <option>Active</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h5 class="section-title">Health Indicators</h5>

                <div class="mb-3">
                    <label class="form-label">Existing Condition</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-heart-pulse"></i></span>
                        <select name="disease" class="form-select rounded-end-3" style="border-left:none;">
                            <option>None</option>
                            <option>Diabetes</option>
                            <option>Hypertension</option>
                            <option>Obesity</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cholesterol (mg/dL)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-droplet"></i></span>
                        <input type="number" name="cholesterol" id="cholesterol" class="form-control rounded-end-3" placeholder="Optional" min="100" max="400">
                    </div>
                    <small class="text-muted">Valid range: 100-400 mg/dL</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Blood Pressure (Systolic)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-speedometer2"></i></span>
                        <input type="number" name="bp" id="bp" class="form-control rounded-end-3" placeholder="Optional" min="60" max="200">
                    </div>
                    <small class="text-muted">Valid range: 60-200 mmHg</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Glucose Level (mg/dL)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-capsule"></i></span>
                        <input type="number" name="glucose" id="glucose" class="form-control rounded-end-3" placeholder="Optional" min="50" max="400">
                    </div>
                    <small class="text-muted">Valid range: 50-400 mg/dL</small>
                </div>
            </div>
        </div>

        <input type="hidden" name="bmi" id="bmi">

        <div class="text-center mt-5">
            <button class="btn btn-success btn-lg">
                Generate Plan <i class="bi bi-rocket-takeoff-fill ms-2"></i>
            </button>
        </div>

      </form>
    </div>
  </div>

<script>
// Form Validation
const validationRules = {
  age: { min: 1, max: 120, name: 'Age' },
  height: { min: 50, max: 270, name: 'Height' },
  weight: { min: 20, max: 300, name: 'Weight' },
  cholesterol: { min: 100, max: 800, name: 'Cholesterol', optional: true },
  bp: { min: 60, max: 250, name: 'Blood Pressure', optional: true },
  glucose: { min: 50, max: 1000, name: 'Glucose Level', optional: true }
};

function validateField(fieldId) {
  const field = document.getElementById(fieldId);
  const rules = validationRules[fieldId];
  const value = parseFloat(field.value);
  
  if (!field.value && rules.optional) {
    field.classList.remove('is-invalid');
    field.classList.remove('is-valid');
    return true;
  }
  
  if (!field.value || isNaN(value) || value < rules.min || value > rules.max) {
    field.classList.add('is-invalid');
    field.classList.remove('is-valid');
    return false;
  }
  
  field.classList.remove('is-invalid');
  field.classList.add('is-valid');
  return true;
}

function validateForm(e) {
  e.preventDefault();
  let isValid = true;
  
  for (let fieldId in validationRules) {
    if (!validateField(fieldId)) {
      isValid = false;
    }
  }
  
  if (!isValid) {
    alert('Please check all fields and ensure values are within valid ranges.');
    return false;
  }
  
  // If valid, submit the form
  e.target.submit();
}

// Add validation on input
for (let fieldId in validationRules) {
  const field = document.getElementById(fieldId);
  if (field) {
    field.addEventListener('input', () => validateField(fieldId));
    field.addEventListener('blur', () => validateField(fieldId));
  }
}

// Add form submit validation
document.getElementById('dietForm').addEventListener('submit', validateForm);

// BMI Calculation Logic
function calculateBMI() {
  const h = document.getElementById("height").value / 100;
  const w = document.getElementById("weight").value;
  if (h && w) {
    const bmi = (w / (h * h)).toFixed(2);
    document.getElementById("bmi").value = bmi;
  }
}

document.getElementById("height").addEventListener("input", calculateBMI);
document.getElementById("weight").addEventListener("input", calculateBMI);

// Theme Toggle Logic
function toggleTheme() {
  const theme = document.documentElement.getAttribute("data-theme");
  const newTheme = theme === "light" ? "dark" : "light";
  document.documentElement.setAttribute("data-theme", newTheme);
  
  // Update icon
  const btn = document.querySelector('button[onclick="toggleTheme()"] i');
  if(newTheme === 'dark'){
      btn.className = 'bi bi-moon-stars-fill';
  } else {
      btn.className = 'bi bi-sun-fill';
  }
  
  localStorage.setItem("theme", newTheme);
}

// Init Theme
(function () {
  const savedTheme = localStorage.getItem("theme") || "dark";
  document.documentElement.setAttribute("data-theme", savedTheme);
  
  // Set initial icon
  const btn = document.querySelector('button[onclick="toggleTheme()"] i');
  if(savedTheme === 'light'){
      btn.className = 'bi bi-sun-fill';
  }
})();
</script>

</body>
</html>