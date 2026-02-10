<?php
include "includes/db.php";

require_once "includes/auth.php";
redirect_if_logged_in();

$error = "";
if ($_POST) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $res = $conn->query("SELECT * FROM users WHERE email='$email'");
  $user = $res->fetch_assoc();

  if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid email or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | AI Planner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/loginStyle.css">
</head>

<body>

  <div class="ambient-light light-1"></div>
  <div class="ambient-light light-2"></div>

  <div class="login-card">
    <div class="text-center mb-4">
      <div class="mb-3">
        <span class="d-inline-block p-3 rounded-circle" style="background: rgba(16, 185, 129, 0.1);">
            <i class="bi bi-person-fill fs-2" style="color: var(--accent);"></i>
        </span>
      </div>
      <h2 class="fw-bold mb-1">Welcome Back</h2>
      <p class="text-muted small">Enter your credentials to continue</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i>
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-group">
          <span class="input-group-text rounded-start-3"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control rounded-end-3" placeholder="john@example.com" required>
        </div>
      </div>

      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="form-label mb-0">Password</label>
            </div>
        <div class="input-group">
          <span class="input-group-text rounded-start-3"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" class="form-control rounded-end-3" placeholder="••••••••" required>
        </div>
      </div>

      <button class="btn btn-success w-100 mb-3">
        Login Now <i class="bi bi-arrow-right-short"></i>
      </button>
    </form>

    <div class="text-center">
      <p class="mb-0">
        Don’t have an account? <a href="register.php">Register</a>
      </p>
    </div>
  </div>

<script>
// Check local storage and apply theme immediately
(function () {
  const savedTheme = localStorage.getItem("theme") || "dark";
  document.documentElement.setAttribute("data-theme", savedTheme);
})();
</script>

</body>
</html>