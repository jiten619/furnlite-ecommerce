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

// Hash the password before storing
$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

// Prepare the SQL query to insert user data
$sql = "INSERT INTO userdata (email, password) VALUES ('$email', '$hashed_password')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);
mysqli_stmt_execute($stmt);

// Check if the query was successful
if (mysqli_query($conn, $sql)) {
  echo "Registration successful!";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
