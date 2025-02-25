<!-- Miguel Angel Hornos -->

<!-- pagina per començar a modificar articles a la bd -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <!-- formulari per omplir l'id i modificar el titol i el cos -->
    <h2>Modificar vehicle de la BD</h2><br>

    <form action="../Controlador/modificar.php" method="post">
        <table>
        <label for="id">ID del vehicle a editar*:</label>
        <input type="text" id="id" name="id" placeholder="Introdueix ID del vehicle a editar*" value="<?php echo htmlspecialchars($id ?? ''); ?>">
        
        <label for="marca">Edita la marca:</label>
        <input type="text" id="marca" name="marca" placeholder="Edita la marca" value="<?php echo htmlspecialchars($marca ?? ''); ?>">
        
        <label for="model">Edita el model:</label>
        <input type="text" id="model" name="model" placeholder="Edita el model" value="<?php echo htmlspecialchars($model ?? ''); ?>">
        
        <label for="any">Edita l'any:</label>
        <input type="number" id="any" name="any" placeholder="Edita l'any" value="<?php echo htmlspecialchars($any ?? ''); ?>" max="<?php echo date('Y'); ?>">
        
        <label for="color">Edita el color:</label>
        <input type="text" id="color" name="color" placeholder="Edita el color" value="<?php echo htmlspecialchars($color ?? ''); ?>">
        
        <label for="matricula">Edita la matricula:</label>
        <input type="text" id="matricula" name="matricula" placeholder="Edita la matricula" value="<?php echo htmlspecialchars($matricula ?? ''); ?>">
        
        <label for="imatge">Enllaç de la imatge:</label>
        <input type="text" id="imatge" name="imatge" placeholder="Introdueix l'enllaç de la imatge" value="<?php echo htmlspecialchars($imatge ?? ''); ?>">
        
        <input type="submit" value="Modificar" name="Enviar">
        <input type="reset" name="reset" value="Buidar">

        </table>     
    </form>
<!-- botó per tornar a començar amb l'ultima pagina de la llista escollida-->
    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>

<?php
// mostra la llista d'articles a sota de tot
include_once "../Controlador/llistaArticles.php";
?>