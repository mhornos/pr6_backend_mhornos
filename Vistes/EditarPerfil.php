<?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/editarPerfil.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\Estils\estils.css">
    <title>mhornos</title>
</head>
<body>
    <h2>Editar perfil:</h2><br>
    
    <form action="../Controlador/editarPerfil.php" method="post">
    <div class="imatge-editar">
        <img src="<?php echo htmlspecialchars(obtenirImatgeEdicio($_SESSION['usuari'])); ?>" alt="">
    </div><br>

    <p>Editar nom d'usuari:</p>
    <input type="text" id="usuari" name="usuari" placeholder="Nom d'usuari" value="<?php echo htmlspecialchars($_SESSION['usuari'] ?? ''); ?>">
    <p>Editar correu electronic:</p>
    <input type="email" id="correu" name="correu" placeholder="Correu" value="<?php echo htmlspecialchars(obtenirCorreu($_SESSION['usuari']) ?? ''); ?>">
    <p>Editar ciutat:</p> 
    <input type="text" id="ciutat" name="ciutat" placeholder="Ciutat" value="<?php echo htmlspecialchars(obtenirCiutat($_SESSION['usuari']) ?? ''); ?>">
    <p>Editar imatge</p>

    <input type="text" id="imatge" name="imatge" placeholder="Enllaç d'imatge" value="<?php echo (obtenirImatge($_SESSION['usuari']) == 'imgs/senseFoto.png') ? '' : htmlspecialchars(obtenirImatge($_SESSION['usuari'])); ?>">
    <input type="submit" name="Editar" value="Editar">
    </form>

    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>