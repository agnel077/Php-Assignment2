<?php
include 'db.php';

// Start a new session or resume the existing session
session_start();

// Variable to store login message
$loginMessage = '';

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to select user data based on the entered username
    $sql = "SELECT * FROM customer WHERE username=?";
    
    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Get the query result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If user is found in the database
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // If entered password matches the hashed password in the database, set session variable for username
            $_SESSION['username'] = $username;
            $loginSuccess = true; // Setting a flag for successful login
        } else {
            // If password is incorrect, set an error message
            $loginMessage = "Incorrect password!";
        }
    } else {
        // If user is not found in the database, set an error message
        $loginMessage = "User not found! Please register.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My BMW Sales Page">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <?php if (isset($loginSuccess) && $loginSuccess) { ?>
            <!-- Displaying welcome content if login was successful -->
            <h2>Login Success</h2>
            <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
            <p>This content is only visible after login.</p>
        <?php } else { ?>
            <!-- Showing login form if not logged in -->
            <h2>Login</h2>

            <?php if (!empty($loginMessage)) { ?>
                <!-- Displaying error message if login failed -->
                <p><?php echo $loginMessage; ?></p>
            <?php } ?>

            <form action="" method="post">
                <!-- Login form -->
                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <input type="submit" value="Login">
            </form>

            <!-- Link to registration page if not registered -->
            <p>Are you not registered? Click to register. <a href="register.php">Register here</a></p>
        <?php } ?>
    </div>
</body>
</html>
