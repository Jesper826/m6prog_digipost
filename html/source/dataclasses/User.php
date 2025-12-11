<?php
 
class User
{
    public int $idUser;
    public string $token;
    public string $username;
 
    public function __construct(int $idUser, string $token, string $username)
    {
        $this->idUser = $idUser;
        $this->token = $token;
        $this->username = $username;
    }

    public static function GetUserById(int $id, $connection)
    {
        $stmt = $connection->prepare('SELECT idUser, token, username FROM User WHERE idUser = ?');
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function GetAllUsers($connection)
    {
        $res = $connection->query('SELECT idUser, token, username FROM User');
        if (!$res) return [];
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        return $rows;
    }
} 