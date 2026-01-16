<?php

namespace pratilib\domain\entities;

class Praticien2moyen
{
    public string $Praticien_id;
    public int $Moyen_id;

    public function __construct(int $Praticien_id, int $Moyen_id)
    {
        $this->Praticien_id = $Praticien_id;
        $this->Moyen_id = $Moyen_id;
    }

    public function getPraticienId(): string
    {
        return $this->Praticien_id;
    }

    public function getMoyenId(): int
    {
        return $this->Moyen_id;
    }
}