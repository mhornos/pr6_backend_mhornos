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
    <form action="../Controlador/canviarPassw.php" method="post">
    <label for="contrasenya">Contrasenya actual:</label>
    <input type="password" id="contrasenya" name="contrasenya" placeholder="Introdueix la teva contrasenya actual">

    <label for="contrasenyaNova1">Nova contrasenya:</label>
    <input type="password" id="contrasenyaNova1" name="contrasenyaNova1" placeholder="Introudeix la nova contrasenya">

    <label for="contrasenyaNova2">Confirmació nova contrasenya:</label>
    <input type="password" id="contrasenyaNova2" name="contrasenyaNova2" placeholder="Repeteix la nova contrasenya">

    <p>La contrasenya ha de tenir almenys 8 caràcters, un número, una majúscula i una minúscula.</p><br>

    <input type="submit" name="Canviar" value="Canviar">
    </form>

    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>