<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "", "user_details");

// If connection fails, handle the error
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Escape user input to prevent SQL injection
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Hash the password for comparison (should be done before storing)
$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

// Prepare the SQL query to check for user
$sql = "SELECT * FROM userdata WHERE email = '$email' AND password = '$hashed_password'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);
mysqli_stmt_execute($stmt);

if (!$stmt || !mysqli_stmt_execute($stmt)) {
    echo "Login failed: " . mysqli_error($conn);
    exit();
}

$result = mysqli_stmt_get_result($stmt);

// Check if user exists and password matches
if (mysqli_num_rows($result) > 0) {
  // Login successful - Start a session or use another method for authentication
  session_start();
  $_SESSION['email'] = $email;
  header("Location: welcome.php"); // Redirect to a welcome page or profile
} else {
  // Login failed - Display error message
  echo "Invalid username or password";
}

mysqli_close($conn);
?>
