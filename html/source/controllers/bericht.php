<?php

header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../dataclasses/Bericht.php';
include_once __DIR__ . '/helpers.php';
include_once __DIR__ . '/models/BerichtResponse.php';

$envFile = __DIR__ . '/../../.env';
$env = [];
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
}

$dbHost = $env['DB_HOST'] ?? getenv('DB_HOST') ?: 'digipost';
$dbName = $env['DB_NAME'] ?? getenv('DB_NAME') ?: 'digipost';
$dbUser = $env['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: 'digipost_user';
$dbPass = $env['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$dbPass = trim($dbPass, '"');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(403);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

function handleGet($dbHost, $dbUser, $dbPass, $dbName)
{
    $connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($connection->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'DB connection failed: ' . $connection->connect_error]);
        exit;
    }

    $request_url = explode('/', $_SERVER['REQUEST_URI']);
    if (isset($request_url[2]) && is_numeric($request_url[2])) {
        $id = (int)$request_url[2];
        $row = Bericht::GetBerichtById($id, $connection);
        if ($row === null) {
            http_response_code(404);
            echo json_encode(['error' => 'Bericht not found']);
        } else {
            $resp = new BerichtResponse($row, $connection);
            http_response_code(200);
            echo json_encode($resp->toArray());
        }
        $connection->close();
        return;
    }

    $rows = Bericht::GetAllBerichten($connection);
    $out = [];
    foreach ($rows as $r) {
        $out[] = (new BerichtResponse($r, $connection))->toArray();
    }
    http_response_code(200);
    echo json_encode($out);
    $connection->close();
}

handleGet($dbHost, $dbUser, $dbPass, $dbName);
exit;

