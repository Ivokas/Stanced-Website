<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Email existing verification
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifies password
        if (password_verify($password, $user['password'])) {
            //Successfull Login, defines session
            $_SESSION['user_name'] = $user['name'];
            header("Location: Forum.php");
            exit();
        } else {
            echo "Wrong password! <a href='login.html'>Try again.</a>";
        }
    } else {
        echo "Email not found! <a href='login.html'>Try another.</a>";
    }
}
?>
