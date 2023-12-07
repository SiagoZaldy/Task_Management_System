<?php
// Include the database connection file
include('db_connect.php');

// Initialize variables
$firstname = $lastname = $email = $password = $confirm_password = $selected_role = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password using MD5
    $confirm_password = md5($_POST['confirm_password']); // Hash the confirm password using MD5
    $selected_role = $_POST['role']; // Get the selected role

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match.";
    } else {
        // Check if the email already exists
        $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email_sql);

        if ($result->num_rows > 0) {
            // Email already exists, show alert and go back to login.php
            echo '<script>alert("Email already exists. Please use a different email.");</script>';

        } else {
            // Email doesn't exist, proceed with registration
            // SQL query to insert user data into the "users" table
            $sql = "INSERT INTO users (firstname, lastname, email, password, type, avatar, date_created) VALUES ('$firstname', '$lastname', '$email', '$password', $selected_role, 'no-image-available.png', NOW())";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // Registration successful
                echo '<script>alert("Registration successful!");</script>';
                echo '<script>window.location.href = "login.php";</script>';
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
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
    <title>User Registration</title>
</head>
<style>
    body {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f0f0f0; /* Optional background color */
    }

    .regis_container {
        border: 2px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        width: 80%; /* Adjust as needed */
        max-width: 400px; /* Set a maximum width if desired */
        background: linear-gradient(to right, #1E5128, #191A19); /* Form background color */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional box shadow */
    }

    .regis_form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        color: white;
    }

    .regis_form div {
        display: flex;
        flex-direction: row; /* Display label and input in a row */
        align-items: center; /* Align items vertically */
    }

    .regis_form label {
        margin-right: 10px; /* Add margin between label and input */
        flex-shrink: 0; /* Prevent label from shrinking */
        min-width: 120px; /* Set a minimum width for the label */
    }

    .regis_form input,
    .regis_form select {
        flex: 1; /* Take remaining space */
        padding: 5px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .regis_form input[type="submit"],
    .regis_form button {
        padding: 10px;
        background-color: #4CAF50; /* Button color */
        color: #fff; /* Text color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .regis_form button {
        background-color: #ccc; /* Cancel button color */
    }

    .regis_form input[type="submit"]:hover{
        background-color: #387c3b; /* Darker color on hover */
    }
    .regis_form button:hover{
        background-color: #005B41;
    }
</style>

</head>
<body>
<div class="regis_container">
        <form method="post" action="" class="regis_form">
            <div>
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" required>
            </div>

            <div>
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>

            <div>
                <label for="role">Current role:</label>
                <select name="role" required>
                   
                    <option value="2">Project Manager</option>
                    <option value="3">Employee</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <input type="submit" value="Register">
            <button type="button" onclick="goToLogin()">Cancel</button>
        </form>
    </div>
    <script>
        // JavaScript function to navigate back to login.php
        function goToLogin() {
            window.location.href = "login.php";
        }
    </script>

</body>
</html>
