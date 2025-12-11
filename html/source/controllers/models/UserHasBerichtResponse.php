<?php

include_once __DIR__ . '/../../dataclasses/Ontvanger.php';
include_once __DIR__ . '/../helpers.php';

class UserHasBerichtResponse
{
    private array $data;

    public function __construct(array $row)
    {
        $berichtId = isset($row['Bericht_idbericht']) ? (int)$row['Bericht_idbericht'] : 0;
        $userId = isset($row['User_idUser']) ? (int)$row['User_idUser'] : 0;

        $this->data = [
            'bericht' => [
                'id' => $berichtId,
                'link' => GetApiPath('bericht', $berichtId)
            ],
            'user' => [
                'id' => $userId,
                'username' => $row['username'] ?? null,
                'link' => GetApiPath('user', $userId)
            ]
        ];
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
