<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
    <form method='POST' action='autenticar_usuario.php'>
        <label for='email'>Email</label>
        <input type='email' name='email' required/> <br>

        <label for='senha'>senha</label>
        <input type='password' name='senha' required/> <br>

        <button type='submit'>Logar</button>
    </form>
    <?php
    if(isset($_GET['msg'])) {
        echo $_GET['msg'];
    }
    ?>
</body>
</html>