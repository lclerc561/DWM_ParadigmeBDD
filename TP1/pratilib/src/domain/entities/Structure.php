<?php

namespace pratilib\domain\entities;
use Doctrine\Common\Collections\Collection;

class Structure
{
    public string $id;
    public string $nom;
    public string $adresse;
    public string $ville;
    public string $code_postal;
    public string $telephone;
    public Collection $praticiens;

    public function __construct(string $id, string $nom, string $adresse, string $ville, string $code_postal, string $telephone, Collection $praticiens)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->telephone = $telephone;
        $this->praticiens = $praticiens;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getCodePostal(): string
    {
        return $this->code_postal;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getPraticiens(): Collection
    {
        return $this->praticiens;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

}