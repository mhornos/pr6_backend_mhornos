<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "Model/editarPerfil.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
</head>
<body>

    <!--si l'usuari está logat -->
    <?php if (isset($_SESSION['usuari'])) { ?> 
        <div class="navbar">
            <div class="imatge-perfil">
                <img src="<?php echo htmlspecialchars(obtenirImatge($_SESSION['usuari'])); ?>" alt="">
            </div>
            <div class="dropdown">
                <button class="dropbtn">Menú ▼</button>
                <div class="dropdown-content">
                    <a href="Vistes/EditarPerfil.php"><button>Editar perfil</button></a>
                    <a href="Controlador/logout.php"><button>Deslogar-se</button></a>
                    <a href="Vistes/CanviarPassw.php"><button>Canviar password</button></a>
                    <!-- mostrar només si l'usuari és "admin" -->
                    <?php if ($_SESSION['usuari'] === 'admin') { ?>
                        <a href="Vistes/Usuaris.php"><button>Gestionar usuaris</button></a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- 3 botons que ens envien al document corresponent per tractar les dades -->
        <h3>Que vols fer?</h3> 
        <a href="Vistes/Inserir.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>"> 
            <button>Inserir vehicle</button>
        </a><br>
        <a href="Vistes/Modificar.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Modificar vehicle</button>
        </a><br>
        <a href="Vistes/Esborrar.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Esborrar vehicle</button>
        </a><br><br>

        

    <!-- si l'usuari no està logat -->
    <?php } else { ?> 
        <div class="navbar">
            <div class="dropdown">
                <button class="dropbtn">Menú ▼</button>
                <div class="dropdown-content">
                    <a href="Vistes/Login.php"><button>Logar-se</button></a>
                    <a href="Vistes/Register.php"><button>Registrar-se</button></a>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>
