<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BeneFit</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/indexStyle.css">
</head>

<body>

<nav class="navbar navbar-expand-lg px-4" style="padding: 0.5em;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <i class="bi bi-robot text-gradient fs-3"></i> 
      BeneFit
    </a>

    <div class="ms-auto d-flex align-items-center">
      <button onclick="toggleTheme()" class="btn btn-outline-light me-3 p-2 rounded-circle" style="width: 45px; height: 45px;">
        <i class="bi bi-moon-stars-fill"></i>
      </button>
      <a href="login.php" class="btn btn-outline-light me-2 px-4">Login</a>
      <a href="register.php" class="btn btn-success px-4">Get Started</a>
    </div>
  </div>
</nav>

<section class="section pt-5">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 fade-up">
        <h1 class="display-4 fw-bolder mb-4">
          Personalized Fitness <br>
          <span class="text-gradient">Powered by Intelligence</span>
        </h1>
        <p class="lead mb-4 fs-5">
          Stop guessing. A full-stack machine learning system that analyzes your unique biometrics to engineer the perfect diet and lifestyle plan.
        </p>
        <div class="d-flex gap-3">
          <a href="login.php" class="btn btn-lg btn-success px-5">
            Start Free 
          </a>
          <a href="#how-it-works" class="btn btn-lg btn-outline-light px-4">
            How it works
          </a>
        </div>
        
      </div>

      <div class="col-lg-6 text-center fade-up" style="animation-delay: 0.2s;">
        <div class="hero-img-wrapper">
            <img src="https://images.unsplash.com/photo-1554284126-aa88f22d8b74?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                 class="img-fluid shadow-lg"
                 alt="Healthy lifestyle">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="text-center mb-5 fade-up">
      <h2 class="display-6 fw-bold mb-3">Why This System?</h2>
      <p class="mx-auto" style="max-width: 600px;">
        Generic diet plans fail because they ignore your biology. Our AI engine adapts specifically to your metabolic data.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4 fade-up" style="animation-delay: 0.1s;">
        <div class="feature-card h-100">
          <i class="bi bi-cpu feature-icon"></i>
          <h4>AI-Driven Decisions</h4>
          <p>
            Advanced ML models analyze BMI, activity levels, cholesterol, and glucose to predict health risks.
          </p>
        </div>
      </div>

      <div class="col-md-4 fade-up" style="animation-delay: 0.2s;">
        <div class="feature-card h-100">
          <i class="bi bi-bullseye feature-icon"></i>
          <h4>Goal Oriented</h4>
          <p>
            Whether targeting fat loss, hypertrophy, or maintenance, the algorithm adjusts calories dynamically.
          </p>
        </div>
      </div>

      <div class="col-md-4 fade-up" style="animation-delay: 0.3s;">
        <div class="feature-card h-100">
          <i class="bi bi-shield-lock feature-icon"></i>
          <h4>Secure & Private</h4>
          <p>
            Your health data is encrypted. We use secure sessions and strict MySQL schemas to protect your privacy.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="how-it-works" class="section bg-opacity-5">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6 text-center fade-up" style="animation-delay: 0.2s;">
        <div class="hero-img-wrapper">
            <img src="https://media.istockphoto.com/id/1128687113/photo/healthy-food-selection-with-fruits-vegetables-seeds-super-foods-cereals.jpg?s=612x612&w=0&k=20&c=aRK0IbovFgrFzcbNszfHctAd4AHZl8khYMiDTLZ5Qjw="
                 class="img-fluid shadow-lg"
                 alt="Healthy food">
        </div>
      </div>

      <div class="col-md-6 order-1 order-md-2 fade-up">
        <h2 class="display-6 fw-bold mb-4">How It Works</h2>
        <ul class="list-unstyled custom-list fs-5">
          <li>
             <i class="bi bi-person-plus-fill text-primary"></i> Create your secure account
          </li>
          <li>
             <i class="bi bi-activity text-danger"></i> Enter biometric & lifestyle data
          </li>
          <li>
             <i class="bi bi-lightning-charge-fill text-warning"></i> AI predicts optimal diet type
          </li>
          <li>
             <i class="bi bi-basket2-fill text-success"></i> Get personalized meal plans
          </li>
          <li>
             <i class="bi bi-graph-up-arrow text-info"></i> Track progress over time
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container text-center">
    <p class="text-uppercase fw-bold letter-spacing-2 mb-4">Powered by Modern Tech</p>

    <div class="row g-4 justify-content-center">
      <div class="col-6 col-md-3">
          <div class="feature-card tech-card py-3">
              <i class="bi bi-code-square text-warning"></i> Python ML
          </div>
      </div>
      <div class="col-6 col-md-3">
          <div class="feature-card tech-card py-3">
              <i class="bi bi-box-seam text-info"></i> Flask API
          </div>
      </div>
      <div class="col-6 col-md-3">
          <div class="feature-card tech-card py-3">
              <i class="bi bi-server text-primary"></i> PHP
          </div>
      </div>
      <div class="col-6 col-md-3">
          <div class="feature-card tech-card py-3">
              <i class="bi bi-database text-danger"></i> MySQL
          </div>
      </div>
    </div>
  </div>
</section>

<section class="section pt-0">
  <div class="container">
    <div class="glass p-5 text-center position-relative overflow-hidden">
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:300px; height:300px; background:var(--accent); filter:blur(100px); opacity:0.2;"></div>
        
      <h2 class="fw-bold display-5 relative-z">Ready to Transform?</h2>
      <p class="lead mt-3 mb-4 relative-z">
        Join the future of intelligent nutrition planning today.
      </p>
      <a href="register.php" class="btn btn-lg btn-success px-5 fw-bold relative-z">
        Create Free Account
      </a>
    </div>
  </div>
</section>

<footer class="text-center py-4">
  <small>© 2026 BeneFit | An AI Diet & Fitness Planner</small>
</footer>

<script>
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