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
    <title> Cadastro</title>
</head>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<body>
<?php
echo 'Seja bem vindo ' . $_SESSION['nome'] . '!';
echo '<a href=logout_usuario.php>Sair</a>';
?>

<h1>Formulario de Cadastro</h1>

<form method="POST" action="cadastrar_usuario.php">
    <label for="email">Email</label>
    <input type="email" name="email" required/> <br>

    <label for="nome">Nome</label>
    <input type="text" name="nome" required/> <br>

    <label for="senha">Senha</label>
    <input type="password" name="senha" required/> <br>

    <button type="submit">Enviar</button>
</form>

<h1>Usuarios Cadastrados</h1>
<?php
    require('config.php');

    $usuarios = $db->query('SELECT * FROM usuarios');
    // var_dump($usuarios);

    echo '<table>';
        echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nome</th>';
            echo '<th>Email</th>';
            echo '<th>Ação</th>';
        echo'</tr>';
        while ($row = $usuarios->fetchArray(SQLITE3_ASSOC)) {
            echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td><a href=deletar_usuario.php?' . $row['id'] . '>Deletar</a> <a href=editar.php?' . $row['id'] . '>Editar</a></td>';    
            echo'</tr>';
        };
    echo '</table>';
    

?>
</body>
</html>