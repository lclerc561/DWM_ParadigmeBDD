<?php

namespace pratilib\domain\entities;

class MotifVisite
{
    public int $id;
    public string $libelle;
    public Specialite $specialite;



    public function __construct(int $id, string $libelle, Specialite $specialite)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->specialite = $specialite;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }
}