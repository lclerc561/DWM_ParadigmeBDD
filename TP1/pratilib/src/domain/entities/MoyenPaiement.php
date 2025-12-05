<?php

namespace pratilib\domain\entities;
class MoyenPaiement
{
    public int $id;
    public string $libelle;

    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }
}