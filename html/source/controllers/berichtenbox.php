<?php

header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../dataclasses/Bericht.php';
include_once __DIR__ . '/models/BerichtenboxResponse.php';

$envFile = __DIR__ . '/../../.env';
$env = [];
if (file_exists($envFile)) $env = parse_ini_file($envFile);

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

function handleBerichtenbox($dbHost, $dbUser, $dbPass, $dbName)
{
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'DB connection failed']);
        return;
    }

    $request_url = explode('/', $_SERVER['REQUEST_URI']);
    if (!isset($request_url[2]) || !is_numeric($request_url[2])) {
        http_response_code(400);
        echo json_encode(['error' => 'User id required, e.g. /berichtenbox/1']);
        $conn->close();
        return;
    }

    $userId = (int)$request_url[2];
    $rows = Bericht::GetBerichtenByUser($userId, $conn);

    $resp = new BerichtenboxResponse($userId, $rows);
    echo json_encode($resp->toArray());
    $conn->close();
}

handleBerichtenbox($dbHost, $dbUser, $dbPass, $dbName);
exit;
