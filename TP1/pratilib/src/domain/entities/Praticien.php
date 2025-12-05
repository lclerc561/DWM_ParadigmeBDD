<?php
namespace pratilib\domain\entities;
use Doctrine\Common\Collections\Collection;

class Praticien
{
    public string $id;
    public string $nom;
    public string $rpps_id;
    public string $prenom;
    public string $titre;
    public string $ville;
    public string $email;
    public string $telephone;
    public bool $organisation;
    public bool $accepte_nouveau_patient;
    public ?Specialite $specialite = null;
    public ?Structure $structure = null;
    public Collection $motifs;



    public function __construct(
        string $id, 
        string $nom,
        string $rpps_id, 
        string $prenom,
        string $titre, 
        string $ville, 
        string $email, 
        string $telephone,
        bool $organisation,
        bool $accepte_nouveau_patient,
        Specialite $specialite,
        Structure $structure
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->rpps_id = $rpps_id;
        $this->prenom = $prenom;
        $this->titre = $titre;
        $this->ville = $ville;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->organisation = $organisation;
        $this->accepte_nouveau_patient = $accepte_nouveau_patient;
        $this->specialite = $specialite;
        $this->structure = $structure;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getRppsId(): string
    {
        return $this->rpps_id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function isOrganisation(): bool
    {
        return $this->organisation;
    }

    public function isAccepteNouveauPatient(): bool
    {
        return $this->accepte_nouveau_patient;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function getStructure(): Structure
    {
        return $this->structure;
    }

    public function getMotifs(): Collection
    {
        return $this->motifs;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

}