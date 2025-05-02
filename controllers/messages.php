<?php
include 'db/database.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // User is not logged in, show the message to log in
    echo "<p class='login-message'>Please log in to see messages.</p>";
} else {
    // User is logged in, show the messages
    $stmt = $dbh->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='messages-page'>";
    echo "<h2>Messages</h2>";

    echo "<div class='messages-table'>";
    echo "<div class='table-header'>
            <div class='table-header-item'>Sender</div>
            <div class='table-header-item'>Message</div>
            <div class='table-header-item'>Time</div>
          </div>";

    foreach ($messages as $message) {
        // Check if the sender is a guest or logged in user
        if (empty($message['name'])) {
            $sender = "Guest"; // If the name is empty, it's a guest
        } else {
            $sender = htmlspecialchars($message['name']); // If the name exists, show the actual sender name
        }

        echo "<div class='table-row'>
                <div class='table-item'>{$sender}</div>
                <div class='table-item'>" . htmlspecialchars($message['message']) . "</div>
                <div class='table-item'>" . date('Y-m-d H:i:s', strtotime($message['created_at'])) . "</div>
              </div>";
    }

    echo "</div>"; // Close messages-table div
    echo "</div>"; // Close messages-page div
}

?>