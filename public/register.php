<?php
include "includes/db.php";

require_once "includes/auth.php";
redirect_if_logged_in();

$success_message = "";
$error_message = "";

if ($_POST) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

  // Check if email already exists
  $check_email = $conn->query("SELECT id FROM users WHERE email='$email'");
  
  if ($check_email->num_rows > 0) {
    $error_message = "Email already exists";
  } else {
    $conn->query("INSERT INTO users(name,email,password)
                  VALUES('$name','$email','$pass')");
    $success_message = "Registration Successful";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account | AI Planner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/registerStyle.css">
</head>

<body>

  <div class="ambient-light light-1"></div>
  <div class="ambient-light light-2"></div>

  <div class="register-card">
    <div class="text-center mb-4">
      <div class="mb-3">
        <i class="bi bi-robot fs-1" style="color: var(--accent);"></i>
      </div>
      <h2 class="fw-bold mb-1">Create Account</h2>
      <p class="text-muted small">Join the future of fitness planning</p>
    </div>

    <?php if ($success_message): ?>
      <div class="alert alert-success text-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo $success_message; ?>
        <p class="mb-0 mt-2">
          <a href="login.php" class="fw-bold">Click here to login</a>
        </p>
      </div>
    <?php else: ?>

    <?php if ($error_message): ?>
      <div class="alert alert-danger text-center" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i><?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <div class="input-group">
          <span class="input-group-text rounded-start-3"><i class="bi bi-person"></i></span>
          <input type="text" name="name" class="form-control rounded-end-3" placeholder="John Doe" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-group">
          <span class="input-group-text rounded-start-3"><i class="bi bi-envelope"></i></span>
          <input type="email" name="email" class="form-control rounded-end-3" placeholder="john@example.com" required>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text rounded-start-3"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" class="form-control rounded-end-3" placeholder="••••••••" required>
        </div>
      </div>

      <button class="btn btn-success w-100 mb-3">
        Get Started 🚀
      </button>
    </form>

    <div class="text-center">
      <p class=" mb-0">
        Already a member? <a href="login.php">Log In</a>
      </p>
    </div>

    <?php endif; ?>
  </div>

<script>
// Immediately check local storage and apply the theme
(function () {
  const savedTheme = localStorage.getItem("theme") || "dark";
  document.documentElement.setAttribute("data-theme", savedTheme);
})();
</script>

</body>
</html>