<?php
// Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// incloem el model
require_once dirname(__DIR__) . '/Model/llistaArticles.php';

// definir el término de búsqueda
$cercaCriteri = $_GET['cercaCriteri'] ?? '';

// emmagatzemem la cerca a la sessió
$_SESSION['cercaCriteri'] = $cercaCriteri;

// definir resultats per pàgina des del menú desplegable o per defecte
if (isset($_GET['resultatsPerPagina'])) {
    $_SESSION['resultatsPerPagina'] = (int)$_GET['resultatsPerPagina'];
}
$resultatsPerPagina = $_SESSION['resultatsPerPagina'] ?? 5;

// definir la pàgina actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) {
    $paginaActual = 1;
}

// obtenir el criteri d'ordenació
$criteriOrdenacio = isset($_GET['orden']) ? $_GET['orden'] : '';
// comprovar si l'usuari està loguejat
$usuariLoguejat = $_SESSION['usuari'] ?? null;

// obtenir el total d'articles
$totalArticles = obtenirTotalArticles($usuariLoguejat, $cercaCriteri);

// calcular el nombre total de pàgines
$totalPags = ceil($totalArticles / $resultatsPerPagina);

// obtenir els articles amb els filtres seleccionats
$articles = obtenirArticles($paginaActual, $resultatsPerPagina, $criteriOrdenacio, $usuariLoguejat, $cercaCriteri);

// mostrar els menús i la paginació
echo "<div class='formularios-container'>";
echo "<form method='get' class='controls'>";
echo "<input type='text' name='cercaCriteri' value='" . htmlspecialchars($cercaCriteri) . "' placeholder='Introudeix el text per buscar:'>";

echo "<button type='submit'>Cercar</button>";
echo "</form>";

echo "<form method='get' class='controls'>";
echo "<label for='resultatsPerPagina'>Articles per pàgina:</label>";
echo "<select name='resultatsPerPagina' id='resultatsPerPagina'>";
$opcionsArticlesPagina = [5, 10, 15, 20, 25];
foreach ($opcionsArticlesPagina as $opcio) {
    $seleccionat = $resultatsPerPagina === $opcio ? 'selected' : '';
    echo "<option value='$opcio' $seleccionat>$opcio</option>";
}
echo "</select>";

echo "<label for='orden'>Ordenar per:</label>";
echo "<select name='orden' id='orden'>";
$opcionsOrdenacio = [
    '' => 'Predeterminat',
    'any_asc' => 'Any (Ascendent)',
    'any_desc' => 'Any (Descendent)',
    'marca_asc' => 'Marca (Ascendent)',
    'marca_desc' => 'Marca (Descendent)',
    'model_asc' => 'Model (Ascendent)',
    'model_desc' => 'Model (Descendent)',
];
foreach ($opcionsOrdenacio as $valor => $etiqueta) {
    $seleccionat = $criteriOrdenacio === $valor ? 'selected' : '';
    echo "<option value='$valor' $seleccionat>$etiqueta</option>";
}
echo "</select>";
echo "<button type='submit'>Aplicar</button>";
echo "</form>";
echo "</div>";

echo "<div class='paginacio'>";

// botó de página anterior
if ($paginaActual > 1) {
    echo '<a href="?pagina=' . ($paginaActual - 1) . '&resultatsPerPagina=' . $resultatsPerPagina . '&orden=' . $criteriOrdenacio . '&cercaCriteri=' . $cercaCriteri . '">Anterior</a>';
}

// enllaços a totes les paginas
for ($i = 1; $i <= $totalPags; $i++) {
    if ($i == $paginaActual) {
        echo '<strong>' . $i . '</strong>';
    } else {
        echo '<a href="?pagina=' . $i . '&resultatsPerPagina=' . $resultatsPerPagina . '&orden=' . $criteriOrdenacio . '&cercaCriteri=' . $cercaCriteri . '">' . $i . '</a>';
    }
}

// botó de página seguent
if ($paginaActual < $totalPags) {
    echo '<a href="?pagina=' . ($paginaActual + 1) . '&resultatsPerPagina=' . $resultatsPerPagina . '&orden=' . $criteriOrdenacio . '&cercaCriteri=' . $cercaCriteri . '">Següent</a>';
}

echo "</div><br>";

echo "<div class='articles-container'>";

// mostrar articles
    if (count($articles) > 0) {
        foreach ($articles as $article) {
            echo "<div class='article-box'>";
            echo "<p>" . htmlspecialchars($article['ID']) . "</p>";  
            echo "<h3>" . htmlspecialchars($article['marca']) . " " . $article['model'] .  "</h3>";
            echo "<p><strong>Any:</strong> " . htmlspecialchars($article['any']) . "</p>";
            echo "<p><strong>Color:</strong> " . htmlspecialchars($article['color']) . "</p>";
            echo "<p><strong>Matrícula:</strong> " . htmlspecialchars($article['matricula']) . "</p>";
            echo "<p><strong>Mecànic:</strong> " . htmlspecialchars($article['nom_usuari']) . "</p>";
            echo "<p><strong>Ciutat:</strong> " . htmlspecialchars($article['ciutat']) . "</p>";
            
            if (!empty($article['imatge'])) {
                echo "<img src='" . htmlspecialchars($article['imatge']) . "' width='150' alt='Imatge de l'article'>";
            } else {
                echo "<p><br>No hi ha imatge</p>";
            }

            echo '<form action="Controlador/articles.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="' . htmlspecialchars($article['ID']) . '">
                <input type="hidden" name="marca" value="' . htmlspecialchars($article['marca']) . '">
                <input type="hidden" name="model" value="' . htmlspecialchars($article['model']) . '">
                <input type="hidden" name="any" value="' . htmlspecialchars($article['any']) . '">
                <input type="hidden" name="color" value="' . htmlspecialchars($article['color']) . '">
                <input type="hidden" name="matricula" value="' . htmlspecialchars($article['matricula']) . '">
                <input type="hidden" name="imatge" value="' . htmlspecialchars($article['imatge']) . '">
                <button type="submit" name="boton" value="Editar">Editar</button>
                <button type="submit" name="boton" value="Eliminar">Eliminar</button>
                <button type="submit" name="boton" value="QR">QR</button>
            </form>';

            echo "</div>";
        }
    } else {
        echo "<p>No s'han trobat vehicles.</p>";
    }

echo "</div>";
?>
