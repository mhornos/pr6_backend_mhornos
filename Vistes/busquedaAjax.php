   <!-- Miguel Angel Hornos Granda -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuari = $_SESSION['usuari'] ?? null;
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

<!-- AJAX per admin -->

    <h2>Llista de vehicles:</h2><br>
    
    <?php if (isset($_SESSION['usuari']) && $_SESSION['usuari'] === 'admin') { ?>

    <form class="ajax">
        <section style="margin: 20px 0;">
            <h2>Cerca amb AJAX:</h2>
    
            <label for="ajax-q">Buscar:</label>
            <input id="ajax-q" type="text" placeholder="marca, model, matrícula, usuari...">
    
            <label for="ajax-limit">Limit:</label>
            <select id="ajax-limit">
                <option value="999999999999" selected>Tots</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20" >20</option>
            </select>
    
            <p id="ajax-status" style="margin-top:10px;"></p>
    
            <div id="ajax-results"></div>
    
        </section>
    </form>

<?php } ?>

    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
    </a>    

    <script src="../js/articlesAjax.js"></script>

</body>
</html>