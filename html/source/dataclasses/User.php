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
} 