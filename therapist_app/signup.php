<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $specialization = $_POST['specialization'];
    $about = $_POST['about'];

    $sql = "INSERT INTO users (username, email, password, role, age, location, specialization, about)
            VALUES ('$username', '$email', '$password', '$role', '$age', '$location', '$specialization', '$about')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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
    <h2>Register</h2>
    <form method="POST">
        <div class="input-group">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role" required>
            <option value="user">User</option>
            <option value="therapist">Therapist</option>
        </select><br>
        <input type="number" name="age" placeholder="Age"><br>
        <input type="text" name="location" placeholder="Location"><br>
        <input type="text" name="specialization" placeholder="Specialization"><br>
        <textarea name="about" placeholder="About yourself"></textarea><br>
        </div>
        <button type="submit" class="btn">Sign Up</button>
    </form>
    <p class="signup-text">Have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
