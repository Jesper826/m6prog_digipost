<?php

class Ontvanger
{
    public int $Bericht_idbericht;
    public int $User_idUser;

    public function __construct(int $Bericht_idbericht, int $User_idUser)
    {
        $this->Bericht_idbericht = $Bericht_idbericht;
        $this->User_idUser = $User_idUser;
    }

    public static function GetByKeys(int $berichtId, int $userId, $connection)
    {
        $stmt = $connection->prepare('SELECT Bericht_idbericht, User_idUser FROM Ontvanger WHERE Bericht_idbericht = ? AND User_idUser = ?');
        if (!$stmt) return null;
        $stmt->bind_param('ii', $berichtId, $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function GetOntvangersByBericht(int $berichtId, $connection)
    {
        $stmt = $connection->prepare('SELECT o.Bericht_idbericht, o.User_idUser, u.username FROM Ontvanger o JOIN User u ON o.User_idUser = u.idUser WHERE o.Bericht_idbericht = ?');
        if (!$stmt) return [];
        $stmt->bind_param('i', $berichtId);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }
}