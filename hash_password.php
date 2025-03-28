
<?php
echo password_hash('1234', PASSWORD_BCRYPT);
?>
<?php
// Example to generate a hashed password
$password = '1234'; // Replace with your actual password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password; // Copy this hash to use in your SQL query
?>
<?php
include('db.php');

// Define the admin credentials
$username = 'Vishwa Cosmo Admin';
$email = 'vishwacosmoadmin@gmail.com';
$password = '1234'; // Replace this with the actual password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';
$registration_status = 'approved';

// Insert the admin user into the database
$query = "INSERT INTO users (username, email, password, role, registration_status)
          VALUES ('$username', '$email', '$hashed_password', '$role', '$registration_status')";

if (mysqli_query($conn, $query)) {
    echo "Admin user added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
