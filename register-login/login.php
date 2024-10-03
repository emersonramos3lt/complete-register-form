<?php

    $is_invalid = false;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $mysqli = require __DIR__ . "/database.php";

        $sql = sprintf("SELECT * FROM user
                        WHERE email = '%s'",
                        $mysqli->real_escape_string($_POST["email"]));

        $result = $mysqli->query($sql); // Faz a consulta no MySQL

        $user = $result->fetch_assoc(); // Após a consulta busca uma linha, onde o conteúdo dessa linha é armazenado em $user, onde criamos

        if ($user) {

          if (password_verify($_POST["password"], $user["password_hash"])) {

            // Pega os dados do usuário e leva a outra página
            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;

          }

        }

        $is_invalid = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Login</h1>
    <?php if ($is_invalid): ?>
        <p>Invalid login</p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
                value="<?= htmlspecialchars($_POST["email"] ?? "")  ?>">
    <!-- O uso de value evita que email, seja retirado do input quando clicar no button -->

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Log in</button>
    </form>

</body>
</html>