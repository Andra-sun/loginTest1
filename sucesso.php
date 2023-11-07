<!DOCTYPE html>
<html>

<head>
    <title>Página de Sucesso</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }
    </style>
</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<h1 style='color:green;'>Login bem sucedido!</h1>";
    } else {
        echo "<h1 style='color:red;'>Acesso não autorizado!</h1>";
    }
    ?>

</body>

</html>