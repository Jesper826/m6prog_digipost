<?php

header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../dataclasses/User.php';
include_once __DIR__ . '/models/UserResponse.php';

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

function handleGetUser($dbHost, $dbUser, $dbPass, $dbName)
{
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'DB connection failed']);
        return;
    }

    $request_url = explode('/', $_SERVER['REQUEST_URI']);
    if (isset($request_url[2]) && is_numeric($request_url[2])) {
        $id = (int)$request_url[2];
        $row = User::GetUserById($id, $conn);
        if ($row === null) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            $conn->close();
            return;
        }
        $resp = new UserResponse($row['idUser'], $row['username']);
        echo json_encode($resp->toArray());
        $conn->close();
        return;
    }

    $rows = User::GetAllUsers($conn);
    $mapped = array_map(function($r) {
        $u = new UserResponse($r['idUser'], $r['username']);
        return $u->toArray();
    }, $rows);

    echo json_encode($mapped);
    $conn->close();
}

handleGetUser($dbHost, $dbUser, $dbPass, $dbName);
exit;
