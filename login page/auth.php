<?php
// Database connection
$servername = "127.0.0.1";
$username = "root";  // Change this if you use a different user
$password = "";  // Enter your MySQL password
$dbname = "login_page";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['formType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($formType === 'signup') {
        // Handle signup
        $username = $_POST['username'];
        $dob = $_POST['dob'];

        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('User already exists. Please log in.'); window.location.href='index.html';</script>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, dob) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $dob);

            if ($stmt->execute()) {
                echo "<script>alert('Signup successful! Please log in.'); window.location.href='index.html';</script>";
            } else {
                echo "<script>alert('Error occurred during signup. Please try again.'); window.location.href='index.html';</script>";
            }
        }

        $stmt->close();

    } elseif ($formType === 'login') {
        // Handle login
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            echo "<script>alert('Login successful!'); window.location.href='welcome.html';</script>";
        } else {
            echo "<script>alert('Invalid email or password.'); window.location.href='index.html';</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>
