<!-- Miguel Ángel Hornos -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <!-- formulari que demana les dades del vehicle per generar un article a la bd -->
    <h2>Inserir vehicle a la BD</h2><br>

    <form action="../Controlador/inserir.php" method="post">
        <table>
        <label for="marca">Marca del vehicle*:</label>
        <input type="text" id="marca" name="marca" placeholder="Introdueix la marca del vehicle*" value="<?php echo htmlspecialchars($marca ?? ''); ?>">
        
        <label for="model">Model del vehicle*:</label>
        <input type="text" id="model" name="model" placeholder="Introdueix el model del vehicle*" value="<?php echo htmlspecialchars($model ?? ''); ?>">
        
        <label for="any">Any del vehicle*:</label>
        <input type="number" id="any" name="any" placeholder="Introdueix l'any del vehicle*" value="<?php echo htmlspecialchars($any ?? ''); ?>" max="<?php echo date('Y'); ?>">
        
        <label for="color">Color del vehicle*:</label>
        <input type="text" id="color" name="color" placeholder="Introdueix el color del vehicle*" value="<?php echo htmlspecialchars($color ?? ''); ?>">
         
        <label for="matricula">Matrícula del vehicle*:</label>
        <input type="text" id="matricula" name="matricula" placeholder="Introdueix la matricula del vehicle*" value="<?php echo htmlspecialchars($matricula ?? ''); ?>">
        
        <label for="imatge">Enllaç de la imatge (opcional):</label>
        <input type="text" id="imatge" name="imatge" placeholder="Introdueix l'enllaç de la imatge (opcional)" value="<?php echo htmlspecialchars($imatge ?? ''); ?>">
            
        <input type="submit" value="Inserir" name="Enviar">
        <input type="reset" value="Buidar">
        </table>     
    </form>
<!-- botó per tornar a començar amb l'ultima pagina de la llista escollida-->
    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>

<!-- mostra la llista d'articles a sota de tot -->
<?php
include_once "../Controlador/llistaArticles.php";
?>