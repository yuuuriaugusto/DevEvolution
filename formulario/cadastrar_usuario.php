<?php

require('config.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$stmt = $db->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)');
$stmt->bindValue(':nome', $nome,);
$stmt->bindValue(':email', $email,);
$stmt->bindValue(':senha', $senha);

$result = ($stmt->execute()) ? header('Location: index.php') : "Erro ao cadastrar";




?>