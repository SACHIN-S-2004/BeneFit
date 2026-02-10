<?php
include "includes/db.php";

require_once "includes/auth.php";
require_auth();

// --- KEEPING YOUR ORIGINAL PHP LOGIC INTACT ---
$data = [
    "Age" => (int)$_POST["age"],
    "Gender" => $_POST["gender"],
    "BMI" => (float)$_POST["bmi"],
    "Disease_Type" => $_POST["disease"],
    "Physical_Activity_Level" => $_POST["activity"],
    "Cholesterol_mg/dL" => (float)$_POST["cholesterol"],
    "Blood_Pressure_mmHg" => (float)$_POST["bp"],
    "Glucose_mg/dL" => (float)$_POST["glucose"]
];

// Save inputs
$conn->query("
INSERT INTO health_inputs
(user_id, age, gender, bmi, activity, disease, cholesterol, bp, glucose)
VALUES
({$_SESSION['user_id']},
{$data['Age']},
'{$data['Gender']}',
{$data['BMI']},
'{$data['Physical_Activity_Level']}',
'{$data['Disease_Type']}',
{$data['Cholesterol_mg/dL']},
{$data['Blood_Pressure_mmHg']},
{$data['Glucose_mg/dL']})
");

// Call Flask API
$ch = curl_init("http://127.0.0.1:5000/predict");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

$response['final_diet'] = format_diet_name($response['final_diet']);

// Save result
$conn->query("
INSERT INTO diet_results (user_id, goal, diet)
VALUES ({$_SESSION['user_id']}, '{$response['goal']}', '{$response['final_diet']}')
");

// Function to format diet name to user-friendly display
function format_diet_name($diet_name) {
    // Replace underscores with spaces
    $formatted = str_replace('_', ' ', $diet_name);
    
    // Add ampersand between major diet components
    // Pattern: "High Protein Low Sugar" -> "High Protein & Low Sugar"
    $formatted = preg_replace('/(High Protein|Low Carb|Low Sugar|Low Sodium) (High Protein|Low Carb|Low Sugar|Low Sodium)/', '$1 & $2', $formatted);
    
    return $formatted;
}

// Map icons and images to meals for UI
$meal_config = [
    "breakfast" => [
        "icon" => "bi-sunrise-fill", 
        "color" => "#eab308", 
        // Image of fresh healthy breakfast
        "img" => "https://images.unsplash.com/photo-1494859802809-d069c3b71a8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
    ],
    "lunch" => [
        "icon" => "bi-sun-fill", 
        "color" => "#f97316", 
        // Image of a fresh salad/bowl
        "img" => "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
    ],
    "dinner" => [
        "icon" => "bi-moon-stars-fill", 
        "color" => "#6366f1", 
        // Image of a hearty healthy dinner
        "img" => "https://images.unsplash.com/photo-1467003909585-2f8a72700288?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your AI Diet Plan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/resultStyle.css">
</head>

<body>

  <div class="ambient-light light-1"></div>
  <div class="ambient-light light-2" style="bottom: 0%;"></div>

  <nav class="navbar navbar-expand-lg px-4 py-3">
    <div class="container-fluid">
      <a class="navbar-brand fs-4" href="dashboard.php">
        <i class="bi bi-robot me-2"></i>BeneFit
      </a>
      <div class="ms-auto d-flex align-items-center gap-3">
        <button onclick="toggleTheme()" class="btn btn-outline-secondary rounded-circle p-2" style="width: 40px; height: 40px; border-color: var(--glass-border); color: var(--text-main);">
          <i class="bi bi-moon-stars-fill"></i>
        </button>
        <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4" style="border-color: var(--glass-border); color: var(--text-main);">Dashboard</a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    
    <div class="result-hero fade-up">
        <div class="row g-0 align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <?php if (!empty($response) && isset($response['final_diet'])): ?>
                    <div class="d-inline-block mb-3">
                         <span class="badge bg-success bg-opacity-20 border border-success border-opacity-25 rounded-pill px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i> Analysis Complete
                         </span>
                    </div>
                    
                    <h1 class="display-5 fw-bold mb-2">Your Goal: <span class="text-gradient"><?= htmlspecialchars($response['goal']) ?></span></h1>
                    
                    <div class="mt-4">
                        <p class="text-uppercase letter-spacing-2 fw-bold small mb-2">AI Recommended Strategy</p>
                        <h2 class="display-4 fw-bold text-gradient text-break pe-3" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;"><?= htmlspecialchars(($response['final_diet'])) ?></h2>
                        <p class="lead mt-3">Based on your biometrics, this plan is optimized for your metabolism.</p>
                    </div>  
                    <?php else: ?>
                        <div class="alert alert-danger">
                            Unable to generate diet recommendation. Please try again.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block rounded">
                <div class="hero-image h-100"></div>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <?php 
        $delay_counter = 1;
        foreach (["breakfast", "lunch", "dinner"] as $meal): 
            $config = $meal_config[$meal];
            $color = $config['color'];
            $bg_style = "background: {$color}20; color: $color;"; // 20% opacity hex
        ?>
        
        <div class="col-12 fade-up delay-<?= $delay_counter++ ?>">
            <div class="meal-header">
                <div class="meal-badge" style="<?= $bg_style ?> border: 1px solid <?= $color ?>40;">
                    <i class="bi <?= $config['icon'] ?> fs-5"></i> <?= ucfirst($meal) ?> Plan
                </div>
                <img src="<?= $config['img'] ?>" alt="<?= $meal ?>" class="meal-header-img">
            </div>

            <div class="row g-4">
                <?php foreach ($response[$meal] as $food): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0 text-truncate pe-2" title="<?= htmlspecialchars($food["Food_Item"]) ?>">
                                <?= htmlspecialchars($food["Food_Item"]) ?>
                            </h5>
                            <i class="bi bi-patch-check-fill text-success opacity-50"></i>
                        </div>
                        
                        <div class="d-flex gap-2 mt-auto">
                            <div class="nutrition-pill">
                                <i class="bi bi-fire text-danger"></i> 
                                <?= $food["Calories (kcal)"] ?> kcal
                            </div>
                            <div class="nutrition-pill">
                                <i class="bi bi-egg-fried text-warning"></i> 
                                <?= $food["Protein (g)"] ?>g Protein
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5 pt-4 fade-up delay-4">
        <a href="diet.php" class="btn btn-glass-primary">
            <i class="bi bi-arrow-counterclockwise me-2"></i> Recalculate Plan
        </a>
        <p class="text-muted small mt-3">Not happy with these results? Update your metrics.</p>
    </div>

  </div>

  <footer class="text-center py-3 text-secondary mt-5 mb-1 border-top border-secondary border-opacity-10">
    <small>© 2026 - BeneFit | An AI Diet & Fitness Planner </small>
</footer>

<script>
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