<?php
require('config.php');

$id = intval($_GET['id']);
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $db->prepare('UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id');
$stmt->bindParam(':id', $id, SQLITE3_INTEGER);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);

$result = ($stmt->execute()) ? header('Location: index.php') : "Erro ao atualizar";
?>