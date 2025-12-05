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
}