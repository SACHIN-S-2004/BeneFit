<?php
include "includes/db.php";

require_once "includes/auth.php";
require_auth();

$user_id =  current_user_id();

// Fetch user
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

// Stats
$total_checks = $conn->query(
    "SELECT COUNT(*) AS total FROM health_inputs WHERE user_id=$user_id"
)->fetch_assoc()['total'];

$latest = $conn->query(
    "SELECT * FROM diet_results WHERE user_id=$user_id ORDER BY created_at DESC LIMIT 1"
)->fetch_assoc();

$history = $conn->query(
    "SELECT * FROM diet_results WHERE user_id=$user_id ORDER BY created_at DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<title>Dashboard | AI Diet Planner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/3.0.0-beta.6/aos.css" />

<link rel="stylesheet" href="../assets/dashboardStyle.css">
</head>

<body data-aos-easing="ease-out-cubic" data-aos-duration="1000" data-aos-once="true">

  <nav class="navbar navbar-expand-lg px-4 py-3" style="position: sticky; top: 0; z-index: 1000; background: var(--nav-glass);">
    <div class="container-fluid">
      <a class="navbar-brand fs-4" href="#">
        <i class="bi bi-robot me-2 brand-gradient"></i>BeneFit
      </a>

      <div class="ms-auto d-flex align-items-center gap-3">
        <button onclick="toggleTheme()" class="btn btn-outline-glass rounded-circle p-2" style="width: 42px; height: 42px;">
          <i class="bi bi-moon-stars-fill"></i>
        </button>
        
        <div class="dropdown">
            <button class="btn btn-outline-glass dropdown-toggle px-3 rounded-pill" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2"></i> <?= htmlspecialchars(explode(' ', $user['name'])[0]) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" style="background: var(--bg-color); border: 1px solid var(--glass-border);">
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </div>
      </div>
    </div>
  </nav>

<div class="container py-5 mt-5">

  <div class="row align-items-center g-5 mb-5 pt-4">
    <div class="col-lg-6" data-aos="fade-right">
      <div class="glass p-5 position-relative">
        <span class="badge rounded-pill bg-opacity-25 bg-success text-success mb-3 border border-success px-3">
            <i class="bi bi-stars me-1"></i> Dashboard
        </span>
        <h2 class="display-4 fw-bold mb-4">Hello, <span class="text-gradient"><?= htmlspecialchars($user['name']) ?></span> 👋</h2>
        <p class="lead text-secondary mb-4">
          Your personal health command center is ready. Track your nutrition, analyze AI insights, and stay on target.
        </p>
        <div class="d-flex gap-3">
             <a href="#stats" class="btn btn-outline-light rounded-pill px-4" style="border-color: var(--card-border); color: var(--text-secondary);">View Stats</a>
        </div>
      </div>
    </div>
    
    <div class="col-lg-6 text-center hero-img-container" data-aos="fade-left">
      <img src="https://www.mywellings.com/wp-content/uploads/2025/04/My-Wellings-Community-Personalized-Nutrition-Fine-Tuning-Your-Plate-for-Vibrant-Living.jpg"
           class="img-fluid hero-img" alt="Healthy Lifestyle">
    </div>
  </div>

  <div id="stats" class="row g-4 mb-5">
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
      <div class="stat-card text-center">
        <i class="bi bi-cpu fs-1 mb-3 d-block" style="color: var(--accent);"></i>
        <h5 class="mb-2 text-secondary text-uppercase small ls-1">AI Evaluations</h5>
        <h2 class="display-4 fw-bold text-gradient"><?= $total_checks ?></h2>
      </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
      <div class="stat-card text-center">
        <i class="bi bi-bullseye fs-1 mb-3 d-block text-warning"></i>
        <h5 class="mb-2 text-secondary text-uppercase small ls-1">Current Goal</h5>
        <h2 class="display-6 fw-bold text-gradient"><?= $latest ? htmlspecialchars($latest['goal']) : '—' ?></h2>
      </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
      <div class="stat-card text-center">
        <i class="bi bi-basket2-fill fs-1 mb-3 d-block text-success"></i>
        <h5 class="mb-2 text-secondary text-uppercase small ls-1">Recommended Diet</h5>
        <h2 class="display-6 fw-bold text-gradient"><?= $latest ? htmlspecialchars($latest['final_diet']) : '—' ?></h2>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-5">
    <div class="col-md-7" data-aos="fade-right">
      <div class="glass p-5 h-100 d-flex flex-column justify-content-center align-items-start">
        <h4 class="mb-3 fw-bold"><i class="bi bi-rocket-takeoff-fill me-2 text-warning"></i> Ready for a new plan?</h4>
        <p class="text-secondary mb-4">
          Our AI model has been updated to provide more accurate metabolic predictions. Update your biometrics to get a fresh plan.
        </p>

        <a href="diet.php" class="btn btn-success btn-lg px-5 shadow-lg">
          Generate New Diet Plan <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    </div>

    <div class="col-md-5" data-aos="fade-left">
      <div class="glass p-5 h-100">
        <h5 class="mb-4 fw-bold text-uppercase text-secondary small ls-1">System Status</h5>
        <ul class="list-unstyled text-secondary">
          <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-accent me-3"></i> AI Engine Online</li>
          <li class="mb-3 d-flex align-items-center"><i class="bi bi-shield-lock-fill text-accent me-3"></i> Data Encrypted</li>
          <li class="mb-3 d-flex align-items-center"><i class="bi bi-database-fill text-accent me-3"></i> Database Synced</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="glass p-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-clock-history me-2 text-info"></i> Recent History</h4>
        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10">Last 5 Entries</span>
    </div>

    <?php if ($history->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Date Created</th>
              <th>Goal Type</th>
              <th>Diet Recommendation</th>
              <th class="text-end">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $history->fetch_assoc()): ?>
              <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2 text-secondary"></i>
                        <?= date("M d, Y", strtotime($row['created_at'])) ?>
                    </div>
                </td>
                <td>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                        <?= htmlspecialchars($row['goal']) ?>
                    </span>
                </td>
                <td class="fw-bold text-accent"><?= htmlspecialchars($row['final_diet']) ?></td>
                <td class="text-end">
                    <i class="bi bi-check-circle-fill text-success opacity-75"></i>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="text-center py-5">
          <i class="bi bi-clipboard-x display-4 text-secondary opacity-50"></i>
          <p class="text-secondary mt-3">No history found. Generate your first plan above!</p>
      </div>
    <?php endif; ?>
  </div>

</div>

<footer class="text-center py-3 text-secondary mt-5 border-top border-secondary border-opacity-10">
  <small>© 2026 - BeneFit | An AI Diet & Fitness Planner </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/3.0.0-beta.6/aos.js"></script>
<script>
AOS.init({
    offset: 100,
    duration: 800,
    easing: 'ease-in-out',
    delay: 100,
});

function toggleTheme() {
  const current = document.documentElement.getAttribute("data-theme") || "dark";
  const newTheme = current === "dark" ? "light" : "dark";
  document.documentElement.setAttribute("data-theme", newTheme);
  
  // Update Icon
  const btn = document.querySelector('button[onclick="toggleTheme()"] i');
  if(newTheme === 'light') {
      btn.classList.remove('bi-moon-stars-fill');
      btn.classList.add('bi-sun-fill');
  } else {
      btn.classList.remove('bi-sun-fill');
      btn.classList.add('bi-moon-stars-fill');
  }
  
  localStorage.setItem("theme", newTheme);
}

// Initialize Theme
(function () {
  const saved = localStorage.getItem("theme") || "dark";
  document.documentElement.setAttribute("data-theme", saved);
  
  const btn = document.querySelector('button[onclick="toggleTheme()"] i');
  if(saved === 'light') {
      btn.classList.remove('bi-moon-stars-fill');
      btn.classList.add('bi-sun-fill');
  }
})();
</script>

</body>
</html>