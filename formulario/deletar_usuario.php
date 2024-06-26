<?php

require('config.php');

$id = intval($_GET['id']);
// $id = $_GET['id'];


$stmt = $db->prepare('DELETE FROM usuarios WHERE id= :id');
$stmt->bindParam(':id', $id);

$result = ($stmt->execute()) ? header('Location: index.php') : "Erro ao excluir";
?>