<form method="POST" action="index.php?page=login" class="auth-form">
    <h2>Login</h2>
    
    <label for="login_user">Username:</label>
    <input type="text" id="login_user" name="login_user" required>
    
    <label for="login_pass">Password:</label>
    <input type="password" id="login_pass" name="login_pass" required>
    
    <button type="submit" name="login" class="auth-btn">Login</button>
</form>

<hr class="divider">

<form method="POST" action="index.php?page=login" class="auth-form">
    <h2>Register</h2>
    
    <label for="reg_name">Full Name:</label>
    <input type="text" id="reg_name" name="reg_name" required>
    
    <label for="reg_user">Username:</label>
    <input type="text" id="reg_user" name="reg_user" required>
    
    <label for="reg_pass">Password:</label>
    <input type="password" id="reg_pass" name="reg_pass" required>
    
    <button type="submit" name="register" class="auth-btn">Register</button>
</form>

<?php
include 'db/database.php';

// Register User
if (isset($_POST['register'])) {
    $name = $_POST['reg_name'];
    $user = $_POST['reg_user'];
    $pass = sha1($_POST['reg_pass']); // Hashing password
    
    // Insert into database
    $stmt = $dbh->prepare("INSERT INTO users (full_name, username, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$name, $user, $pass]);
        echo "<p>Registration successful. Please login.</p>";
    } catch (PDOException $e) {
        echo "<p>Error: Username might be taken.</p>";
    }
}

// Login User
if (isset($_POST['login'])) {
    $user = $_POST['login_user'];
    $pass = sha1($_POST['login_pass']); // Hash password for comparison
    
    // Check if the user exists in the database
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$user, $pass]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Create session for logged in user
        $_SESSION['user'] = [
            'username' => $row['username'],
            'full_name' => $row['full_name']
        ];
        header('Location: index.php');
        exit;
    } else {
        echo "<p>Invalid login. Please check your username or password.</p>";
    }
}
?>