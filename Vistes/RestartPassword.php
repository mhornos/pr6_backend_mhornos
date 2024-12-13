<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="../Estils/estils.css">
</head>
<body>
    <h2>Canviar contrasenya:</h2><br>
    <form action="../Controlador/restartPassword.php?token=<?= htmlspecialchars($_GET['token']) ?>" method="post">
        <p>Introdueix la nova contrasenya:</p><br>
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">
        <input type="password" id="contrasenya" name="contrasenya" placeholder="Contrasenya">
        <input type="password" id="contrasenya2" name="contrasenya2" placeholder="Repeteix la contrasenya">
        <p>La contrasenya ha de tenir almenys 8 caràcters, un número, una majúscula i una minúscula.</p><br>
        <input type="submit" name="Canviar" value="Canviar">    
    </form>
</body>
</html>