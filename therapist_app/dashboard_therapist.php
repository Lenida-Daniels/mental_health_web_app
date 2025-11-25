<?php
include 'config.php';
include 'functions.php';
checkLogin();

if (!isTherapist()) {
    header("Location: dashboard_user.php");
    exit();
}

$therapist_id = $_SESSION['id'];
$result = mysqli_query($conn, "
    SELECT DISTINCT sender_id FROM messages WHERE receiver_id=$therapist_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
            background: linear-gradient(135deg, #d9ecff, #f4faff);
        }

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 50px auto;
        }

        .header-box {
            text-align: center;
            padding: 20px;
        }

        .header-box h2 {
            font-size: 34px;
            color: #1c4b73;
            margin-bottom: 5px;
        }

        .header-box p {
            font-size: 17px;
            color: #4b5b6b;
        }

        /* Chat List Wrapper */
        .chat-list {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        /* Chat Card */
        .chat-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.08);
            transition: 0.3s ease;
            border: 1px solid #e6f2ff;
        }

        .chat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0,0,0,0.12);
        }

        .user-icon {
            height: 50px;
            width: 50px;
            background: #3baeea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            margin-bottom: 10px;
            box-shadow: 0 4px 10px rgba(59,174,234,0.3);
        }

        .chat-card strong {
            font-size: 20px;
            color: #123a56;
            display: block;
            margin-bottom: 10px;
        }

        .chat-btn {
            display: inline-block;
            background: #3baeea;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.25s;
        }

        .chat-btn:hover {
            background: #1a8ec8;
        }

        /* Logout button */
        .logout {
            display: block;
            width: max-content;
            margin: 50px auto;
            background: #ff6a6a;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(255,0,0,0.2);
        }

        .logout:hover {
            background: #e04343;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-box">
        <h2>Welcome, Therapist</h2>
        <p>Your active user chats are listed below</p>
    </div>

    <div class="chat-list">
        <?php while ($row = mysqli_fetch_assoc($result)): 
            $user_id = $row['sender_id'];
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id=$user_id"));
            $initial = strtoupper($user['username'][0]);
        ?>
        <div class="chat-card">
            <div class="user-icon"><?php echo $initial; ?></div>
            <strong><?php echo $user['username']; ?></strong>
            <a class="chat-btn" href="chat.php?user_id=<?php echo $user_id; ?>">Open Chat</a>
        </div>
        <?php endwhile; ?>
    </div>

    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>
