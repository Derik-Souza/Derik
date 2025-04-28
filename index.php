<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "portal_aluno";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se enviou o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Proteção contra SQL Injection
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Login realizado com sucesso!');</script>";
        header("homeAluno/index.html");
        exit();
    } else {
        echo "<script>alert('Email ou senha incorretos!');</script>";
    }
}
?>

<!-- HTML do seu site (não alterei nada) -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login | Portal do Aluno</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
   /* Modo Claro (Light Mode) */
    body.light-mode {
        background-color: #f4f4f4;
        color: #000000;
        padding: 20px;  
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
    }

    .login-container.light-mode {
        background-color: white;
        color: #000000;
    }

    button.light-mode {
        background-color: #FF0000;
        color: white;
        font-family: Arial, sans-serif;
        display: flex;
    }

    button.light-mode:hover {
        background-color: #000000;
    }

    /* Dark Mode */
    body.dark-mode {
        background-color: #000000;
        color: #ffffff;
        padding: 20px;
        margin: 0;
    }

    .login-container.dark-mode {
        background-color: #333333;
        color: #ffffff;
    }

    button.dark-mode {
        background-color: #333333;
        color: #FF0000;
    }

    button.dark-mode:hover {
        background-color: #FF0000;
        color: #333333;
    }

    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .login-container {
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    #btn {
        padding: 10px;
        border-radius: 5px;
        border: none;
        color: white;
        background-color: #FF0000; /* Cor do botão no Modo Claro */
        cursor: pointer;
    }

    #btn:hover {
        background-color: #ff7575; /* Cor do botão no Modo Claro */
    }

    #btn.dark-mode {
        background-color: #333333; /* Cor do botão no Modo Escuro */
        color: #ffffff;
    }

    button:hover {
        background-color: #000000;
    }

    @media (max-width: 600px) {
        body {
            padding: 10px;
        }

        .login-container {
            width: 100%;
            box-shadow: none;
        }
    }

    /* Styles for the mode toggle button */
    #toggle-mode {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 10px;
        font-size: 14px;
        cursor: pointer;
        background-color: #000000;  /* Cor do botão no Modo Claro */
        color: white;
        border: none;
        border-radius: 5px;
    }

    #toggle-mode.light-mode {
        background-color: #000000;  /* Cor no Modo Claro */
        color: white;
    }

    #toggle-mode.dark-mode {
        background-color: #ffffff;  /* Cor no Modo Escuro */
        color: #000000;
    }

    #toggle-mode:hover {
        background-color: #434343;
    }

    /* Center the image inside the container */
    .img {
        display: flex;            /* Define a div como um contêiner flexível */
        justify-content: center;  /* Alinha a imagem horizontalmente no centro */
        align-items: center;      /* Alinha a imagem verticalmente no centro */
        height: 300px;            /* Defina a altura do contêiner */
        width: 100%;              /* O contêiner ocupa toda a largura disponível */
        padding: 0;            /* Remove o preenchimento interno */
        margin: 0;             /* Remove a margem externa */
    }

    .img img {
        max-width: 100%;          /* Garante que a imagem não ultrapasse o limite do contêiner */
        max-height: 100%;         /* Garante que a imagem não ultrapasse o limite do contêiner */
        object-fit: contain;      /* Mantém a proporção da imagem */
    }
    .login-container h6 {
        margin-top: 10px;
        font-size: 14px;
        color: #666666; /* Cor do texto no Modo Claro */

    }
    .login-container{
       border: 1px solid #ffffff; /* Borda do contêiner no Modo Escuro */
        border-radius: 5px; /* Bordas arredondadas */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra do contêiner no Modo Claro */
        transition: background-color 0.3s, color 0.3s; /* Transição suave para as mudanças de cor */
    }

  </style>
</head>

<body class="light-mode">
  <!-- Botão para alternar tema -->
  <button id="toggle-mode" class="light-mode">Tema Escuro</button>

  <div class="login-container">
    <h1>Login</h1>
    <h6>Escola Estadual Clotilde Onfri de Campos</h6>
    <form method="POST" action="">
        <div class="img">
            <img id="Img_tema_Preto" src="Branco.png" alt="logo-portal-do-aluno">
            <img id="Img_tema_Branco" src="Preto.png" alt="">
        </div>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <div>
            <button id="btn" type="submit">Entrar</button>
        </div>
    </form>
  </div>

  <script>
   // Ação do botão para alternar entre os modos
    const toggleButton = document.getElementById('toggle-mode');
    const lightImage = document.getElementById('Img_tema_Branco');
    const darkImage = document.getElementById('Img_tema_Preto');
    
    // Verificar se o usuário já tem preferência salva
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        document.body.classList.remove('light-mode');
        toggleButton.classList.add('dark-mode');
        toggleButton.classList.remove('light-mode');
        toggleButton.textContent = "Tema Branco";  // Atualiza o texto
        // Exibir imagem do tema escuro e ocultar a do tema claro
        lightImage.style.display = 'none';
        darkImage.style.display = 'block';
    } else {
        document.body.classList.add('light-mode');
        document.body.classList.remove('dark-mode');
        toggleButton.classList.add('light-mode');
        toggleButton.classList.remove('dark-mode');
        toggleButton.textContent = "Tema Escuro";  // Atualiza o texto
        // Exibir imagem do tema claro e ocultar a do tema escuro
        lightImage.style.display = 'block';
        darkImage.style.display = 'none';
    }

    // Ação do botão para alternar entre os modos
    toggleButton.addEventListener('click', () => {
        if (document.body.classList.contains('light-mode')) {
            document.body.classList.remove('light-mode');
            document.body.classList.add('dark-mode');
            toggleButton.classList.remove('light-mode');
            toggleButton.classList.add('dark-mode');
            toggleButton.textContent = "Tema Branco";  // Atualiza o texto
            localStorage.setItem('theme', 'dark');  // Salvar preferência
            // Exibir imagem do tema escuro e ocultar a do tema claro
            lightImage.style.display = 'none';
            darkImage.style.display = 'block';
        } else {
            document.body.classList.remove('dark-mode');
            document.body.classList.add('light-mode');
            toggleButton.classList.remove('dark-mode');
            toggleButton.classList.add('light-mode');
            toggleButton.textContent = "Tema Escuro";  // Atualiza o texto
            localStorage.setItem('theme', 'light');  // Salvar preferência
            // Exibir imagem do tema claro e ocultar a do tema escuro
            lightImage.style.display = 'block';
            darkImage.style.display = 'none';
        }
    });
  </script>

</body>
</html>
