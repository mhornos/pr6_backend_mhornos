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
        <img src="<?php echo htmlspecialchars(obtenirImatgeEdicio($_SESSION['usuari'])); ?>" alt="Imatge de perfil">
    </div><br>

    <label for="usuari">Editar nom d'usuari:</label>
    <input type="text" id="usuari" name="usuari" placeholder="Nom d'usuari" value="<?php echo htmlspecialchars($usuari ?? ''); ?>">

    <label for="correu">Editar correu electronic:</label>
    <input type="email" id="correu" name="correu" placeholder="Correu" value="<?php echo htmlspecialchars($correu ?? ''); ?>">

    <label for="ciutat">Editar ciutat:</label>
    <input type="text" id="ciutat" name="ciutat" placeholder="Ciutat" value="<?php echo htmlspecialchars($ciutat ?? ''); ?>">

    <label for="imatge">Editar imatge:</label>
    <input type="text" id="imatge" name="imatge" placeholder="Enllaç d'imatge" value="<?php echo htmlspecialchars($imatge ?? ''); ?>">

    <input type="submit" name="Editar" value="Editar">
</form>


    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>