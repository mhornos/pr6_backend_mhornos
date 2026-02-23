<!-- Miguel Angel Hornos Granda -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuari = $_SESSION['usuari'] ?? null;

require_once "../Model/articles.php";
$vehicles = obtenirVehicles($usuari);

$returnTo = $_SERVER['REQUEST_URI'];
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
    <h2>Gestionar vehicles:</h2><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Model</th>
                <th>Any</th>
                <th>Color</th>
                <th>Matrícula</th>
                <th>Mecànic</th>
                <th>Ciutat</th>
                <th>Opcions</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($vehicles)) {
                foreach ($vehicles as $vehicle) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehicle['ID']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['marca']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['any']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['color']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['matricula']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['nom_usuari']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['ciutat']); ?></td>
                        
                        <td>
                        <form class="sense-fons"action="../Controlador/articles.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicle['ID']); ?>">
                                <input type="hidden" name="marca" value="<?php echo htmlspecialchars($vehicle['marca']); ?>">
                                <input type="hidden" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>">
                                <input type="hidden" name="any" value="<?php echo htmlspecialchars($vehicle['any']); ?>">
                                <input type="hidden" name="color" value="<?php echo htmlspecialchars($vehicle['color']); ?>">
                                <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($vehicle['matricula']); ?>">
                                <input type="hidden" name="imatge" value="<?php echo htmlspecialchars($vehicle['imatge']); ?>">
                                
                                <input type="hidden" name="return_to" value="<?php echo htmlspecialchars($returnTo); ?>">

                                <?php if (!empty($_SESSION['usuari'])) { ?>
                                <button type="submit" name="boton" value="Editar">Editar</button>
                                <button type="submit" name="boton" value="Eliminar">Eliminar</button>
                                <button type="submit" name="boton" value="QR">QR</button>
                                <?php } ?>
                            </form>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="10">No hi ha cap vehicle registrat.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>   
    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>    
</body>
</html>