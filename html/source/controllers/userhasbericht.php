<?php

header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../dataclasses/Ontvanger.php';
include_once __DIR__ . '/models/UserHasBerichtResponse.php';

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

function handleUserHasBericht($dbHost, $dbUser, $dbPass, $dbName)
{
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'DB connection failed']);
        return;
    }

    $request_url = explode('/', $_SERVER['REQUEST_URI']);

    if (isset($request_url[2]) && is_numeric($request_url[2])) {
        $userId = (int)$request_url[2];

        include_once __DIR__ . '/../dataclasses/Bericht.php';
        $rows = Bericht::GetBerichtenByUser($userId, $conn);
        include_once __DIR__ . '/models/BerichtResponse.php';
        $out = [];
        foreach ($rows as $r) {
            $out[] = (new BerichtResponse($r, $conn))->toArray();
        }

        http_response_code(200);
        echo json_encode($out);
        $conn->close();
        return;
    }

    $stmt = $conn->prepare('SELECT o.Bericht_idbericht, o.User_idUser, u.username FROM Ontvanger o JOIN User u ON o.User_idUser = u.idUser ORDER BY o.Bericht_idbericht DESC');
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Query prepare failed']);
        $conn->close();
        return;
    }
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $stmt->close();

    $mapped = array_map(function($r) {
        $m = new UserHasBerichtResponse($r);
        return $m->toArray();
    }, $rows);

    http_response_code(200);
    echo json_encode($mapped);
    $conn->close();
}

handleUserHasBericht($dbHost, $dbUser, $dbPass, $dbName);
exit;
