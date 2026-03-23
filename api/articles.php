<?php

// api rest: proveir api propia per consultar els meus articles en format json

declare(strict_types=1);

// inicia la sessio si encara no esta activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// indica que la resposta sera json
header('Content-Type: application/json; charset=utf-8');

try {
    // carrega la connexio a la base de dades
    require_once __DIR__ . '/../Model/connexio.php';
    
    // comprova que l'usuari estigui autenticat
    if (!isset($_SESSION['usuari'])) {
        echo json_encode(['error' => 'no autoritzat❌']);
        exit;
    }

    // guarda l'usuari de la sessio i comprova si es admin
    $usuariSessio = $_SESSION['usuari'];
    $esAdmin = ($usuariSessio === 'admin');

    // recull els parametres de la url
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $q = trim($_GET['q'] ?? '');
    $limit = (int)($_GET['limit'] ?? 20);

    // limita el maxim i minim de resultats
    $limit = max(1, min($limit, 100));

    // si arriba un id, retorna nomes un article
    if ($id) {
        if ($esAdmin) {
            $stmt = $connexio->prepare("SELECT * FROM article WHERE ID = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $connexio->prepare("SELECT * FROM article WHERE ID = :id AND nom_usuari = :usuari");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':usuari', $usuariSessio, PDO::PARAM_STR);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // si no existeix o no te permis, retorna error 404
        if (!$row) {
            echo json_encode(['error' => 'no trobat❌']);
            exit;
        }

        // envia l'article en format json
        echo json_encode(['data' => $row], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // prepara la consulta general de llistat
    $sql = "SELECT * FROM article";
    $params = [];

    // si no es admin, nomes pot veure els seus articles
    if (!$esAdmin) {
        $sql .= " WHERE nom_usuari = :usuari";
        $params[':usuari'] = $usuariSessio;
    }

    // si hi ha text de cerca, afegeix condicions
    if ($q !== '') {
        if (!$esAdmin) {
            $sql .= " AND (marca LIKE :q
                      OR model LIKE :q
                      OR matricula LIKE :q
                      OR nom_usuari LIKE :q)";
        } else {
            $sql .= " WHERE marca LIKE :q
                      OR model LIKE :q
                      OR matricula LIKE :q
                      OR nom_usuari LIKE :q";
        }

        $params[':q'] = "%{$q}%";
    }

    // ordena per id descendent i limita resultats
    $sql .= " ORDER BY ID DESC LIMIT {$limit}";

    // prepara i executa la consulta
    $stmt = $connexio->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $stmt->execute();

    // obte tots els registres trobats
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // envia el recompte i les dades
    echo json_encode([
        'count' => count($rows),
        'data'  => $rows
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    // captura errors interns del servidor
    echo json_encode([
        'error' => 'error intern❌',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}