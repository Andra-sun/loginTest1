<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        session_start();

        $servername = "localhost"; // Substitua com o nome do seu servidor MySQL
        $username = "root"; // Substitua com o nome de usuário do seu MySQL
        $password = ""; // Substitua com a senha do seu MySQL
        $dbname = "usuarios"; // Substitua com o nome do seu banco de dados
        
        // Conectar ao banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se o formulário de registro foi enviado
        // Verifica se o formulário de registro foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email']; // Adicionado campo de e-mail
        
            // Verifica se o nome de usuário e e-mail já estão em uso
            $check_username = "SELECT * FROM usuarios WHERE username='$username' OR email='$email'";
            $result = $conn->query($check_username);

            if ($result->num_rows > 0) {
                echo "O nome de usuário ou e-mail já estão em uso. Por favor, escolha outro.";
            } else {
                // Insere os dados na tabela
                $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";

                if ($conn->query($sql) === TRUE) {
                    // Enviar e-mail de confirmação
                    $to = $email;
                    $subject = "Confirmação de Registro";
                    $message = "Olá $username, obrigado por se registrar! Seu registro foi bem-sucedido.";

                    // Headers do e-mail
                    $headers = "From: camileandradegui@gmail.com\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    // Enviar e-mail
                    if (mail($to, $subject, $message, $headers)) {
                        // E-mail enviado com sucesso
                        echo "Um e-mail de confirmação foi enviado para $email. Por favor, verifique sua caixa de entrada.";
                    } else {
                        // Falha ao enviar o e-mail
                        echo "Houve um erro ao enviar o e-mail de confirmação. Por favor, tente novamente.";
                    }

                    // Defina uma variável de sessão para indicar que o registro foi bem-sucedido
                    $_SESSION['registered'] = true;
                } else {
                    echo "Erro ao inserir dados: " . $conn->error;
                }
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
            <input type="email" name="email" placeholder="E-mail" required><br> <!-- Campo de e-mail adicionado -->
            <input type="submit" name="register" value="Registrar">
        </form>

        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Nome de usuário" required><br>
            <input type="password" name="password" placeholder="Senha" required><br>
            <input type="submit" name="login" value="Entrar">
        </form>
    </div>
</body>

</html>