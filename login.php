<?php
session_start();
include 'db.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Verifica se o email existe
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifica a senha
        if (password_verify($password, $user['password'])) {
            // Login bem-sucedido, define a sessão
            $_SESSION['user_name'] = $user['name'];
            header("Location: Forum.php");
            exit();
        } else {
            echo "Senha incorreta! <a href='login.html'>Tente novamente.</a>";
        }
    } else {
        echo "Email não encontrado! <a href='login.html'>Tente novamente.</a>";
    }
}
?>
