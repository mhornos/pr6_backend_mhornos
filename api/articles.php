<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/../Model/connexio.php';
    
    // if (!isset($_SESSION['usuari'])) {
        // http_response_code(401);
        // echo json_encode(['error' => 'no autoritzat❌']);
        // exit;
    // }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $q = trim($_GET['q'] ?? '');
    $limit = (int)($_GET['limit'] ?? 20);
    $limit = max(1, min($limit, 100));

    // si viene id, devolver 1 artículo
    if ($id) {
        $stmt = $connexio->prepare("SELECT * FROM article WHERE ID = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404);
            echo json_encode(['error' => 'no trobat❌']);
            exit;
        }

        echo json_encode(['data' => $row], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // listado con búsqueda y paginación
    $sql = "SELECT * FROM article";
    $params = [];

    if ($q !== '') {
        $sql .= " WHERE marca LIKE :q
                  OR model LIKE :q
                  OR matricula LIKE :q
                  OR nom_usuari LIKE :q";
        $params[':q'] = "%{$q}%";
    }

    $sql .= " ORDER BY ID DESC LIMIT {$limit}";

    $stmt = $connexio->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'count' => count($rows),
        'data'  => $rows
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error intern',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}