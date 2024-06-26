<?php
    // require('config.php');
    // autenticar();
    session_start();
    if(!$_SESSION['auth']) {
        header('Location: login.php?msg=Faca login');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<body>
<?php
echo 'Seja bem vindo ' . $_SESSION['nome'] . '!    ';
echo '<a href=logout_usuario.php>Sair</a>';
?>

<h1>Formulario de Edição</h1>

<?php
    require('config.php');

    $usuarios = $db->prepare('SELECT * FROM usuarios WHERE id = :id');
    $row = $usuarios->fetchArray(SQLITE3_ASSOC);
    var_dump($usuarios);
    //var_dump($row);
?>

<form method="POST" action="editar_usuario.php">
    <label for="email"><?php echo $row['email'] ?></label>
    <input type="email" name="email" required/> <br>

    <label for="nome"><?php echo $row['nome'] ?></label>
    <input type="text" name="nome" required/> <br>

    <label for="senha"><?php echo $row['senha'] ?></label>
    <input type="password" name="senha" required/> <br>

    <button type="submit">Enviar</button>
</form>
</body>
</html>