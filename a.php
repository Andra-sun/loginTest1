<!DOCTYPE html>
<html>

<head>
    <title>Registro e Login</title>
</head>

<body>

    <?php
    session_start();

    $servername = "localhost"; // Substitua com o nome do seu servidor MySQL
    $username = "root"; // Substitua com o nome de usuário do seu MySQL
    $password = ""; // Substitua com a senha do seu MySQL
    $dbname = "usuarios"; // Substitua com o nome do seu banco de dados
    
    // Conectar ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o formulário de registro foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Insere os dados na tabela
        $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Defina uma variável de sessão para indicar que o registro foi bem-sucedido
            $_SESSION['registered'] = true;
        } else {
            echo "Erro ao inserir dados: " . $conn->error;
        }
    }

    // Verifica se o formulário de login foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Consulta o banco de dados para verificar se o usuário e senha são válidos
        $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $_SESSION['loggedin'] = true;
            header('Location: sucesso.php');
            exit();
        } else {
            echo "Credenciais inválidas. Tente novamente.";
        }
    }
    ?>

    <?php
    // Se o registro foi bem-sucedido, exibe uma mensagem
    if (isset($_SESSION['registered']) && $_SESSION['registered'] === true) {
        echo "<h1 style='color:green;'>Registro bem sucedido! Faça o login abaixo:</h1>";
        unset($_SESSION['registered']); // Limpa a variável de sessão para evitar exibição repetida
    }
    ?>

    <h2>Registro</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Nome de usuário" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>
        <input type="submit" name="register" value="Registrar">
    </form>

    <h2>Login</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Nome de usuário" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>
        <input type="submit" name="login" value="Entrar">
    </form>

</body>

</html>