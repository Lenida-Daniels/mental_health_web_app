<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'user') {
                header("Location: dashboard_user.php");
            } else {
                header("Location: dashboard_therapist.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="logo">MindCare</div>
    <ul class="nav-links">
      <li><a href="login.php">Login</a></li>
      <li><a href="signup.php">Sign Up</a></li>
    </ul>
  </nav>
    <div class="login">
        <h2>Therapist Connect</h2>
        <p>Your wellness, your choice. Find the right therapist near you.</p>
   
    
    <form method="POST">
        <div class="input-group">
        <label>Email</label>
        <input type="text" name="username" placeholder="Enter your email or username" required>
      </div>

      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn">Login</button>
    </form>
    <p class="signup-text">Don’t have an account? <a href="signup.php">Sign up here</a></p>

    </div>
</body>
</html>
