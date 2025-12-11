<?php

include_once __DIR__ . '/../../dataclasses/User.php';
include_once __DIR__ . '/../../dataclasses/Bericht.php';
include_once __DIR__ . '/../helpers.php';

class BerichtenboxResponse
{
    private array $data;

    public function __construct(int $userId, array $berichten)
    {
        $this->data = [
            'user' => [
                'id' => $userId,
                'link' => GetApiPath('user', $userId)
            ],
            'berichten' => []
        ];

        foreach ($berichten as $b) {
            $bid = isset($b['idbericht']) ? (int)$b['idbericht'] : 0;
            $this->data['berichten'][] = [
                'id' => $bid,
                'inhoud' => $b['bericht_inhoud'] ?? null,
                'verzender' => [
                    'id' => isset($b['verzender']) ? (int)$b['verzender'] : 0,
                    'username' => $b['username'] ?? null,
                    'link' => GetApiPath('user', isset($b['verzender']) ? (int)$b['verzender'] : 0)
                ],
                'link' => GetApiPath('bericht', $bid)
            ];
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
