<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_name'])) {
    echo "Acesso negado.";
    exit;
}

// Recupera o ID do usuário logado
$user_name = $_SESSION['user_name'];
$user_query = "SELECT id FROM users WHERE name = '$user_name'";
$user_result = mysqli_query($conn, $user_query);

if ($user_row = mysqli_fetch_assoc($user_result)) {
    $user_id = $user_row['id'];
} else {
    echo "Usuário não encontrado.";
    exit;
}

if ($_GET['action'] === 'load') {
    // Carregar as mensagens
    $query = "SELECT chat_messages.message, chat_messages.created_at, users.name 
              FROM chat_messages 
              JOIN users ON chat_messages.user_id = users.id 
              ORDER BY chat_messages.created_at ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p><strong>" . htmlspecialchars($row['name']) . ":</strong> " . 
                 htmlspecialchars($row['message']) . 
                 " <span style='font-size: 0.8em;'>(" . $row['created_at'] . ")</span></p>";
        }
    }
    exit;
}

if ($_GET['action'] === 'send') {
    // Enviar mensagem
    if (isset($_POST['message'])) {
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $query = "INSERT INTO chat_messages (user_id, message) VALUES ('$user_id', '$message')";
        mysqli_query($conn, $query);
    }
    exit;
}
?>
