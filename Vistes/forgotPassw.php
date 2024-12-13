<!-- Miguel Angel Hornos -->

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
    <form action="../Controlador/forgotPassw.php" method="post">
    <p>T'enviarem un correu per reiniciar la teva contrasenya</p><br>
    
    <input type="email" id="correu" name="correu" placeholder="El teu correu"> 
    <input type="submit" name="Enviar" value="Enviar">
    </form>
    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>