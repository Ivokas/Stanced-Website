<?php
session_start();
include 'db.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Verifica se o email já está registrado
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "This email allready exists. <a href='register.html'> Try another!</a>";
    } else {
        // Insere o usuário na base de dados
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Criptografa a senha
        $insertQuery = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $insertQuery)) {
            header("Location: login.html");
            exit();
        } else {
            echo "Unable to register: " . mysqli_error($conn);
        }
    }
}
?>