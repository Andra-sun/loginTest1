<!DOCTYPE html>
<html>

<head>
    <title>Página de Sucesso</title>
</head>

<body>

    <?php
        session_start();

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo "<h1 style='color:green;'>Login bem sucedido!</h1>";
        } else {
            echo "<h1 style='color:red;'>Acesso não autorizado!</h1>";
        }
    ?>

</body>

</html>