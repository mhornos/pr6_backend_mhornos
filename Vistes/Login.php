<!-- Miguel Angel Hornos -->
<?php
require "../Controlador/cookies.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="../Estils/estils.css">
</head>
<body>
    <h2>Inicia sessió:</h2><br>
    <form action="../Controlador/login.php" method="post">
    <label for="usuari">Usuari</label>
    <input type="text" id="usuari" name="usuari" placeholder="Introdueix l'usuari" value="<?php echo htmlspecialchars(obtenirCookie('usuari') ?? ''); ?>"> 

    <label for="contrasenya">Contrasenya</label>
    <input type="password" id="contrasenya" name="contrasenya" placeholder="Introdueix la contrasenya" value="<?php echo htmlspecialchars(obtenirCookie('contrasenya') ?? ''); ?>"> 

    <input type="submit" name="Login" value="Login">
    
    <label for="remember_me">
        <input type="checkbox" name="remember_me" id="remember_me" value="1" <?php echo isset($_COOKIE["usuari"]) ? "checked" : ""; ?>> 
        Recordar-me
    </label>
    
    <br>
    No tinc compte: <a href="Register.php"> Crea un compte </a><br>
    He oblidat la contrasenya: <a href="forgotPassw.php"> Recuperar-la </a>
</form>

    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>