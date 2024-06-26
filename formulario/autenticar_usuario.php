<?php
require('config.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $db->prepare('SELECT nome, email, senha FROM usuarios WHERE email = :email');
$stmt->bindParam(':email', $email);
$result = ($stmt->execute());
$usuario = $result->fetchArray(SQLITE3_ASSOC);
if(! $result) {
    echo 'Usuario não encontrado';
    header('Location: login.php?msg=Usuario nao encontrado');
    exit;
}
else {
    if(password_verify($senha, $usuario['senha'])) {
        session_start();
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['auth'] = true;
        header('Location: index.php');
    }
    else {
        header('Location: login.php?msg=Senha nao confere');
        exit;
    }
}
//$usuario = $result->fetchArray(SQLITE3_ASSOC) ? header('Location: index.php') : "Usuario nao encontrado"; header('Location: login.php?msg=Usuario nao encontrado')

?>