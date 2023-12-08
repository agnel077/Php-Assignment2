<?php
include 'db.php';

// Variable to store registration message
$registrationMessage = '';

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username from the form
    $username = $_POST['username'];

    // Hash the entered password 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // SQL query to insert username and hashed password into the 'customer' table
    $sql = "INSERT INTO customer (username, password) VALUES ('$username', '$password')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Set a success message if registration is successful
        $registrationMessage = "You are registered successfully! Please login using the login button below.";
    } else {
        // Display an error message if there's an issue with the SQL query
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        <?php if (!empty($registrationMessage)) { ?>
            <!-- Display the registration message if it's not empty -->
            <p><?php echo $registrationMessage; ?></p>
        <?php } ?>

        <form action="register.php" method="post">
            <?php if (!empty($registrationMessage)) { ?>
                <!-- Display the registration message again within the form if it's not empty -->
                <p><?php echo $registrationMessage; ?></p>
            <?php } ?>

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Register">
        </form>

        <!-- Provide a link to the login page -->
        <p>Click to login <a href="index.php">Login</a></p>
    </div>
</body>
</html>
