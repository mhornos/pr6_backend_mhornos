<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

try {
    $make = trim($_GET['make'] ?? '');

    if ($make === '') {
        http_response_code(400);
        echo json_encode([
            'error' => 'falta el paràmetre make❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $url = 'https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMake/' . rawurlencode($make) . '?format=json';

    $response = @file_get_contents($url);

    if ($response === false) {
        http_response_code(502);
        echo json_encode([
            'error' => 'no s\'ha pogut consultar l\'API externa❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $data = json_decode($response, true);

    if (!is_array($data)) {
        http_response_code(502);
        echo json_encode([
            'error' => 'resposta JSON invàlida de l\'API externa❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $models = [];

    if (!empty($data['Results']) && is_array($data['Results'])) {
        foreach ($data['Results'] as $item) {
            if (!empty($item['Model_Name'])) {
                $models[] = $item['Model_Name'];
            }
        }
    }

    $models = array_values(array_unique($models));
    sort($models);

    echo json_encode([
        'make' => $make,
        'count' => count($models),
        'models' => $models
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'error intern❌',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}