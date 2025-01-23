<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    echo "<p>Acesso negado. Por favor, faça login.</p>";
    exit;
}
$user_name = htmlspecialchars($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo_sf.png" />
    <title>Stanced</title>
    <link rel="stylesheet" href="forum.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
      integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>
<header>
      <nav>
        <ul class="nav-bar">
          <li class="logo">
            <a href="ShowRoom.html"
              ><img src="images/logo_sf.png" alt="logo"
            /></a>
          </li>
          <input type="checkbox" id="check" />
          <span class="menu">
            <li><a href="ShowRoom.html">Home</a></li>
            <li><a href="Gallery.html">Gallery</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="Contacts.html">Contact</a></li>
            <li><a href="Login.html">Forum</a></li>
            <label for="check" class="close-menu"
              ><i class="fas fa-times"></i
            ></label>
          </span>
          <label for="check" class="open-menu"
            ><i class="fas fa-bars"></i
          ></label>
        </ul>
      </nav>
    </header>
    <div class="forum-container">
        <div class="header">
            <h1>Welcome, <?php echo $user_name; ?></h1>
            <a href="logout.php">Logout</a>
        </div>

        <div class="chat-box" id="chat-box">
        </div>

        <form class="chat-form" id="chat-form">
            <input type="text" id="message" placeholder="Type a message" required>
            <button type="submit">Send</button>
        </form>
    </div>
    <div class="sub">
        <h2>Want to submit images of your project?</h2>
        <center>
        <a href="Submit.html" class="button-56-link">
            <button class="button-56" role="button">Submit</button>
        </a>
        </center>
       
    </div>
    <footer>
      <p class="copyright">Copyright © 2024 STANCED. All rights reserved.</p>
    </footer>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message');

        // Função para carregar mensagens
        async function loadMessages() {
            try {
                const response = await fetch('chat.php?action=load');
                const messages = await response.text();
                chatBox.innerHTML = messages;
                chatBox.scrollTop = chatBox.scrollHeight; // Rolagem automática para o final
            } catch (error) {
                console.error('Erro ao carregar mensagens:', error);
            }
        }

        // Função para enviar mensagens
        async function sendMessage(message) {
            try {
                await fetch('chat.php?action=send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `message=${encodeURIComponent(message)}`
                });
                messageInput.value = '';
                loadMessages();
            } catch (error) {
                console.error('Erro ao enviar mensagem:', error);
            }
        }

        // Evento de envio do formulário
        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message) {
                sendMessage(message);
            }
        });

        // Carregar mensagens periodicamente
        setInterval(loadMessages, 3000);
        loadMessages(); // Carregar inicialmente
    </script>
</body>
</html>
