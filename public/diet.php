<?php
include "../includes/db.php";

require_once "../includes/auth.php";
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
        <i class="bi bi-robot me-2"></i>AI Planner
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

      <form method="POST" action="result.php">
        
        <div class="row g-5">
            <div class="col-lg-6">
                <h5 class="section-title">Physical Metrics</h5>
                
                <div class="mb-3">
                    <label class="form-label">Age</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-calendar3"></i></span>
                        <input type="number" name="age" class="form-control rounded-end-3" placeholder="e.g. 25" required>
                    </div>
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
                        <input type="number" step="0.1" id="height" class="form-control rounded-end-3" placeholder="e.g. 175" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Weight (kg)</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-person-standing"></i></span>
                        <input type="number" step="0.1" id="weight" class="form-control rounded-end-3" placeholder="e.g. 70" required>
                    </div>
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
                        <input type="number" name="cholesterol" class="form-control rounded-end-3" placeholder="Optional">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Blood Pressure</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-speedometer2"></i></span>
                        <input type="number" name="bp" class="form-control rounded-end-3" placeholder="Optional">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Glucose Level</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-capsule"></i></span>
                        <input type="number" name="glucose" class="form-control rounded-end-3" placeholder="Optional">
                    </div>
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