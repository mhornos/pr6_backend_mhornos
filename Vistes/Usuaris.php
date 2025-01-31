<!-- Miguel Angel Hornos Granda -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuari']) || $_SESSION['usuari'] !== 'admin') {
    header('Location: ../Index.php');
    exit();
}

require_once "../Model/usuaris.php";
$usuaris = obtenirUsuaris();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <h2>Gestionar usuaris:</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Correu</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($usuaris)) {
                foreach ($usuaris as $usuari) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuari['ID']); ?></td>
                        <td><?php echo htmlspecialchars($usuari['nombreUsuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuari['correo']); ?></td>
                        <td>
                            <form action="../Controlador/usuaris.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuari['ID']); ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="10">No hi ha cap usuari registrat.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>   
    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a> 
</body>
</html>