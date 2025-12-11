<?php

class Bericht
{
    public int $idbericht;
    public string $bericht_inhoud;
    public int $verzender;

    public function __construct(int $idbericht, string $bericht_inhoud, int $verzender)
    {
        $this->idbericht = $idbericht;
        $this->bericht_inhoud = $bericht_inhoud;
        $this->verzender = $verzender;
    }

    public static function GetBerichtById(int $id, $connection)
    {
        $sql = "SELECT b.idbericht, b.bericht_inhoud, b.verzender, u.username
                FROM Bericht b
                JOIN User u ON b.verzender = u.idUser
                WHERE b.idbericht = ?";
        $stmt = $connection->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function GetAllBerichten($connection)
    {
        $sql = "SELECT b.idbericht, b.bericht_inhoud, b.verzender, u.username
                FROM Bericht b
                JOIN User u ON b.verzender = u.idUser
                ORDER BY b.idbericht DESC";
        $res = $connection->query($sql);
        if (!$res) return [];
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    public static function GetBerichtenByUser(int $userId, $connection)
    {
        $sql = "SELECT b.idbericht, b.bericht_inhoud, b.verzender, u.username
                FROM Bericht b
                JOIN User u ON b.verzender = u.idUser
                JOIN Ontvanger o ON o.Bericht_idbericht = b.idbericht
                WHERE o.User_idUser = ?
                ORDER BY b.idbericht DESC";
        $stmt = $connection->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }
}
  