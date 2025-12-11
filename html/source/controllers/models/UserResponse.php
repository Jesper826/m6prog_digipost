<?php

class UserResponse
{
    public int $idUser;
    public string $username;

    public function __construct(int $idUser, string $username)
    {
        $this->idUser = $idUser;
        $this->username = $username;
    }

    public function toArray()
    {
        return [
            'idUser' => $this->idUser,
            'username' => $this->username
        ];
    }
}
