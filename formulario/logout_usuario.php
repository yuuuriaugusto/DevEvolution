<?php
session_start();
session_destroy();
header('Location: login.php?msg=Logout efetuado com sucesso');
?>