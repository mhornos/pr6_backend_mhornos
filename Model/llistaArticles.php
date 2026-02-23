<?php
// Miguel Angel Hornos Granda

//obté el total d'articles que compleixen els criteris de cerca i l'usuari loguejat
function obtenirTotalArticles($usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        // consulta SQL per obtenir el total d'articles
        $consulta = "SELECT COUNT(*) as total FROM article WHERE 1=1";
        
        // si s'ha especificat un criteri de cerca, s'afegeix a la consulta
        if ($cercaCriteri) {
            $consulta .= " AND (marca LIKE :criteri OR model LIKE :criteri OR any LIKE :criteri OR color LIKE :criteri OR matricula LIKE :criteri OR nom_usuari LIKE :criteri)";
        }

        // si l'usuari està loguejat, es filtra per nom_usuari
        if ($usuariLoguejat) {
            $consulta .= " AND nom_usuari = :nom_usuari";
        }

        // preparar la consulta
        $consultaTotal = $connexio->prepare($consulta);
        
        // vincula els valors dels paràmetres de cerca i usuari loguejat (si existeixen)
        if ($cercaCriteri) {
            $consultaTotal->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consultaTotal->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        // executar la consulta
        $consultaTotal->execute();
        return $consultaTotal->fetchColumn();
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}

// aquesta funció obté els articles amb els criteris de cerca, l'usuari loguejat i la pàgina actual.
function obtenirArticles($paginaActual, $resultatsPerPagina, $criteriOrdenacio, $usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        // calcular el desplaçament per la paginació
        $offset = ($paginaActual - 1) * $resultatsPerPagina;
        
        // mapa d'ordenació segons els criteris especificats
        $mapaOrdenacio = [
            'id_desc' => 'ID DESC',
            'id_asc' => 'ID ASC',
            'any_asc' => 'any ASC',
            'any_desc' => 'any DESC',
            'marca_asc' => 'marca ASC',
            'marca_desc' => 'marca DESC',
            'model_asc' => 'model ASC',
            'model_desc' => 'model DESC',
        ];
        
        // si no s'ha passat un criteri d'ordenació, no afegir ORDER BY
        $ordenacio = $mapaOrdenacio[$criteriOrdenacio] ?? 'ID DESC';
        
        // consulta SQL per obtenir els articles amb les relacions corresponents a usuaris
        $consulta = "SELECT a.ID AS articleID, a.*, u.ID AS userID, u.ciutat FROM article a LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario WHERE 1=1";
        
        // afegir criteris de cerca
        if ($cercaCriteri) {
            $consulta .= " AND (a.marca LIKE :criteri OR a.model LIKE :criteri OR a.any LIKE :criteri OR a.color LIKE :criteri OR a.matricula LIKE :criteri OR a.nom_usuari LIKE :criteri)";
        }
        
        // filtrar per l'usuari loguejat
        if ($usuariLoguejat) {
            $consulta .= " AND a.nom_usuari = :nom_usuari";
        }

        // afegir ordenació només si es passa un criteri
        if ($ordenacio) {
            $consulta .= " ORDER BY $ordenacio"; 
        }
        
        // afegir límit de resultats per a la paginació
        $consulta .= " LIMIT :offset, :limit";

        // preparar la consulta
        $consulta = $connexio->prepare($consulta);
        
        // vincula els valors dels paràmetres de cerca i usuari loguejat (si existeixen)
        if ($cercaCriteri) {
            $consulta->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consulta->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        // vincula els valors de desplaçament i límit per la paginació
        $consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
        $consulta->bindValue(':limit', $resultatsPerPagina, PDO::PARAM_INT);
        
        // Executar la consulta
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}

?>
