<?php

namespace pratilib\domain\entities;
use Doctrine\Common\Collections\Collection;

class Specialite
{
    public int $id;
    public string $libelle;
    public string $description;
    public Collection $praticiens;
    public Collection $motifs;

    public function __construct(int $id, string $libelle, string $description, Collection $praticiens, Collection $motifs)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    public function getMotifVisite(): Collection
    {
        return $this->motifs;
    }
}
