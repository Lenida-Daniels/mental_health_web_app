<?php
include 'config.php';
include 'functions.php';
checkLogin();

if (!isUser()) {
    header("Location: dashboard_therapist.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role='therapist'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e7f4ff; /* soft skyblue background */
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #3baeea; 
            font-size: 32px;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        h3 {
            text-align: center;
            color: #5a6c7d;
            margin-bottom: 30px;
            font-weight: normal;
        }

        .therapist-card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.06);
            border-left: 5px solid #3baeea; /* cute accent */
            transition: 0.3s ease-in-out;
        }

        .therapist-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 6px 18px rgba(0,0,0,0.1);
        }

        .therapist-card strong {
            font-size: 20px;
            color: #1b3a4b;
        }

        .therapist-card p {
            margin: 5px 0;
            color: #4e5d6a;
        }

        .chat-btn {
            display: inline-block;
            margin-top: 12px;
            background: #3baeea;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.25s;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .chat-btn:hover {
            background: #1a9ad6;
        }

        .logout {
            display: block;
            width: fit-content;
            margin: 40px auto;
            background: #ff7373;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(255,0,0,0.2);
            transition: 0.25s;
        }

        .logout:hover {
            background: #e64e4e;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Welcome to Your Dashboard</h2>
    <h3>Available Therapists</h3>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="therapist-card">
            <strong><?php echo $row['username']; ?></strong>
            <p>Age: <?php echo $row['age']; ?></p>
            <p>Location: <?php echo $row['location']; ?></p>
            <p>Specialization: <?php echo $row['specialization']; ?></p>
            <p>About: <?php echo $row['about']; ?></p>

            <a class="chat-btn" href="chat.php?therapist_id=<?php echo $row['id']; ?>">
                Start Chat
            </a>
        </div>
    <?php endwhile; ?>

    <a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>
