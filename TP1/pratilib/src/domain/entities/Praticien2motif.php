<?php

namespace pratilib\domain\entities;

class Praticien2motif
{
    public string $Praticien_id;
    public int $Motif_id;

    public function __construct(int $Praticien_id, int $Motif_id)
    {
        $this->Praticien_id = $Praticien_id;
        $this->Motif_id = $Motif_id;
    }

    public function getPraticienId(): string
    {
        return $this->Praticien_id;
    }

    public function getMotifId(): int
    {
        return $this->Motif_id;
    }
}