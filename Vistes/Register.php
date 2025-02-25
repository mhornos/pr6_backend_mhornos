<!-- Miguel Angel Hornos -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="..\Estils\estils.css">

</head>
<body>
    <h2>Crear compte de mecànic:</h2><br>
    <form action="../Controlador/register.php" method="post">
    <label for="usuari">Usuari</label>
    <input type="text" id="usuari" name="usuari" placeholder="Introdueix el nom d'usuari">

    <label for="correu">Correu</label>
    <input type="email" id="correu" name="correu" placeholder="Introdueix el correu electrònic">

    <label for="ciutat">Ciutat</label>
    <input type="text" id="ciutat" name="ciutat" placeholder="Introdueix la teva ciutat">

    <label for="imatge">Enllaç de imatge (opcional)</label>
    <input type="text" id="imatge" name="imatge" placeholder="Introdueix un enllaç d'imatge (opcional)">

    <label for="contrasenya">Contrasenya</label>
    <input type="password" id="contrasenya" name="contrasenya" placeholder="Introdueix una contrasenya">

    <label for="contrasenya2">Repeteix la contrasenya</label>
    <input type="password" id="contrasenya2" name="contrasenya2" placeholder="Repeteix la contrasenya">

    <p>La contrasenya ha de tenir almenys 8 caràcters, un número, una majúscula i una minúscula.</p><br>

    <input type="submit" name="Register" value="Registrar-se">
    Ja tinc un compte: <a href="Login.php"> Iniciar sessió </a><br><br>
    
    <?php include_once "../lib/oauth2callback.php";?>
</form>


    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>