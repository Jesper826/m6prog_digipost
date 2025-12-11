<?php

include_once __DIR__ . '/../../dataclasses/Ontvanger.php';
include_once __DIR__ . '/../helpers.php';

class BerichtResponse
{
    private array $data;

    public function __construct(array $berichtRow, $connection)
    {
        $id = isset($berichtRow['idbericht']) ? (int)$berichtRow['idbericht'] : 0;
        $verzenderId = isset($berichtRow['verzender']) ? (int)$berichtRow['verzender'] : 0;

        $this->data = [
            'id' => $id,
            'inhoud' => $berichtRow['bericht_inhoud'] ?? null,
            'verzender' => [
                'id' => $verzenderId,
                'username' => $berichtRow['username'] ?? null,
                'link' => GetApiPath('user', $verzenderId)
            ],
            'ontvangers' => []
        ];

        $ontvangers = Ontvanger::GetOntvangersByBericht($id, $connection);
        foreach ($ontvangers as $o) {
            $uid = isset($o['User_idUser']) ? (int)$o['User_idUser'] : 0;
            $this->data['ontvangers'][] = [
                'id' => $uid,
                'username' => $o['username'] ?? null,
                'link' => GetApiPath('user', $uid)
            ];
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
