<?php
#session_start();
include 'config.php';
include 'functions.php';

checkLogin();

// Ensure database connection exists
if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Database connection not found. Check config.php");
}

$sender_id = $_SESSION['id'] ?? null;

if (!$sender_id) {
    die("Invalid session. Please log in again.");
}

// Get receiver ID (therapist or user)
$receiver_id = 0;
if (!empty($_GET['therapist_id'])) {
    $receiver_id = (int)$_GET['therapist_id'];
} elseif (!empty($_GET['user_id'])) {
    $receiver_id = (int)$_GET['user_id'];
}

if ($receiver_id === 0) {
    die("No chat recipient selected.");
}

// SEND MESSAGE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    if ($message !== '') {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// FETCH MESSAGES
$sql = "
    SELECT sender_id, receiver_id, message, timestamp
    FROM messages
    WHERE (sender_id = ? AND receiver_id = ?)
       OR (sender_id = ? AND receiver_id = ?)
    ORDER BY timestamp ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);

$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 20px;
            color: #333;
        }

        .chat-container {
            width: 60%;
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }

        .messages-box {
            height: 350px;
            overflow-y: auto;
            background: #f8fafc;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #d1d5db;
        }

        .msg {
            padding: 10px 14px;
            margin-bottom: 12px;
            border-radius: 10px;
            max-width: 75%;
            font-size: 14px;
        }

        .you {
            background: #3b82f6;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }

        .them {
            background: #e5e7eb;
            color: #111;
            margin-right: auto;
            border-bottom-left-radius: 0;
        }

        .timestamp {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            color: #6b7280;
        }

        form {
            display: flex;
            margin-top: 15px;
        }

        input[type="text"] {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            outline: none;
            font-size: 14px;
        }

        button {
            background: #3b82f6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #2563eb;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            text-decoration: none;
            color: #475569;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>Chat Room</h2>

    <div class="chat-container">

        <div class="messages-box" id="chatBox">
            <?php if (empty($messages)): ?>
                <p style="color:#6b7280;">No messages yet. Start the conversation 👋</p>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <?php 
                        $isYou = ($msg['sender_id'] == $sender_id);
                        $bubble = $isYou ? "you" : "them";
                        $who = $isYou ? "You" : "them";
                    ?>
                    <div class="msg <?php echo $bubble; ?>">
                        <strong><?php echo $who; ?>:</strong>
                        <?php echo htmlspecialchars($msg['message']); ?>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form method="POST">
            <input type="text" name="message" placeholder="Type a message..." required autocomplete="off">
            <button type="submit">Send</button>
        </form>

        <div class="links">
            <a href="dashboard_user.php">Back</a> |
            <a href="logout.php">Logout</a>
        </div>

    </div>

<script>
    // Auto scroll to bottom
    const box = document.getElementById('chatBox');
    box.scrollTop = box.scrollHeight;
</script>

</body>
</html>
