<?php include 'db/database.php'; ?>

<!-- Contact Form -->
<div class="contact-page">
<form method="POST" action="index.php?page=contact" class="contact-form">
    <h2>Contact Us</h2>

    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea>

    <button type="submit" name="submit" class="submit-btn">Send Message</button>
</form>

    <?php
    // Check if the form was submitted
    if (isset($_POST['submit'])) {
        // For logged-in users, use the name they typed
        if (isset($_SESSION['user'])) {
            $name = htmlspecialchars($_POST['name']);
        } else {
            $name = "Guest";
        }
    
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
    
        $stmt = $dbh->prepare("INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    
        try {
            $stmt->execute([$name, $email, $message]);
            echo "<p class='success-message'>Your message has been sent successfully!</p>";
        } catch (PDOException $e) {
            echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</div>