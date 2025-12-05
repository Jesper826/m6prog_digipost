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
}
  