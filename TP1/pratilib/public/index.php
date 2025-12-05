<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

use Ramsey\Uuid\Uuid;
use pratilib\domain\entities\Specialite;
use pratilib\domain\entities\Praticien;
use pratilib\domain\entities\Structure;
use pratilib\domain\entities\MotifVisite;

$specialiteRepository = $entityManager->getRepository(Specialite::class);
$praticienRepository = $entityManager->getRepository(Praticien::class);
$structureRepository = $entityManager->getRepository(Structure::class);
$motifvisiteRepository = $entityManager->getRepository(MotifVisite::class);

$specialiteID1 = $specialiteRepository->find(1);

echo "Excercice 1 <br>";
echo "1) <br>";
if ($specialiteID1) {
    echo "ID: " . $specialiteID1->getId() . "<br>";
    echo "Libellé: " . $specialiteID1->getLibelle() . "<br>";
    echo "Description: " . $specialiteID1->getDescription() . "<br>";
} else {
    echo "Spécialité avec l'ID 1 non trouvée.";
}

echo "<br>-----------------------<br>";

$praticienID1 = $praticienRepository->find("8ae1400f-d46d-3b50-b356-269f776be532");
echo "2) <br>";
if ($praticienID1) {
    echo "ID: " . $praticienID1->getId() . "<br>";
    echo "Nom: " . $praticienID1->getNom() . "<br>";
    echo "Prénom: " . $praticienID1->getPrenom() . "<br>";
    echo "Ville: " . $praticienID1->getVille() . "<br>";
    echo "Email: " . $praticienID1->getEmail() . "<br>";
    echo "Téléphone: " . $praticienID1->getTelephone() . "<br>";
    
} else {
    echo "Praticien avec l'ID 8ae1400f-d46d-3b50-b356-269f776be532 non trouvé.";
}

echo "<br>-----------------------<br>";
echo "3) <br>";
if ($praticienID1) {
    $specialite = $praticienID1->getSpecialite();
    if ($specialite) {
        echo "Spécialité du praticien:<br>";
        echo "ID: " . $specialite->getId() . "<br>";
        echo "Libellé: " . $specialite->getLibelle() . "<br>";
        echo "Description: " . $specialite->getDescription() . "<br>";
    } else {
        echo "Le praticien n'a pas de spécialité associée.<br>";
    }
    echo"<br>";
    $structure = $praticienID1->getStructure();
    if ($structure){
        echo "Structure d'un praticien:<br>";
        echo "ID: " . $structure->getId() . "<br>";
        echo "Nom: " . $structure->getNom() . "<br>";
        echo "Adresse: " . $structure->getAdresse() . "<br>";
        echo "Ville: " . $structure->getVille() . "<br>";
        echo "Code Postal: " . $structure->getCodePostal() . "<br>";
        echo "Téléphone: " . $structure->getTelephone() . "<br>";
    }
}
else {
    echo "Praticien avec l'ID 8ae1400f-d46d-3b50-b356-269f776be532 non trouvé.";
}


$structure = $structureRepository->find('3444bdd2-8783-3aed-9a5e-4d298d2a2d7c');
echo "<br>-----------------------<br>";
echo "4) <br>";
if ($structure) {
    echo "Structure et praticiens: <br>";
    echo "Structure ID: " . $structure->getId() . "<br>";
    echo "Nom: " . $structure->getNom() . "<br>";
    echo "Adresse: " . $structure->getAdresse() . "<br>";
    echo "Ville: " . $structure->getVille() . "<br>";
    echo "Téléphone: " . $structure->getTelephone() . "<br>";

    echo "<br>Praticiens rattachés :<br>";
    $praticiens = $structure->getPraticiens();

    if (count($praticiens) > 0) {
        foreach ($praticiens as $praticien) {
            echo "<li>" . $praticien->getNom() . " " . $praticien->getPrenom() . " (" . $praticien->getSpecialite()->getLibelle() . ")</li>";
        }
        echo "</ul>";
    } 
    else {
        echo "Aucun praticien rattaché.<br>";
    }
} else {
    echo "Structure avec l'ID 3444bdd2-8783-3aed-9a5e-4d298d2a2d7c non trouvée.<br>";
}

echo "<br>-----------------------<br>";
echo "5) <br>";
if($specialiteID1){
    echo "Motifs de visite pour la spécialité ID 1:<br>";
    $motifs = $specialiteID1->getMotifVisite();

    if (count($motifs) > 0) {
        foreach ($motifs as $motif) {
            echo "<li>". $motif->getLibelle() . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun motif de visite pour cette spécialité.<br>";
    }
}
else{
    echo "Spécialité avec l'ID 1 non trouvée.";
}

echo "<br>-----------------------<br>";
echo "6) <br>";
if ($praticienID1) {
    echo "Liste des motifs pour le praticien " . $praticienID1->getNom() . " :<br>";
    
    $lesMotifs = $praticienID1->getMotifs();

    if (count($lesMotifs) > 0) {
        echo "<ul>";
        foreach ($lesMotifs as $motif) {
            echo "<li>" . $motif->getLibelle() . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun motif associé à ce praticien.<br>";
    }
} else {
    echo "Praticien introuvable.";
}

echo "<br>-----------------------<br>";
echo "7) <br>";
echo "<h3> Création d'un nouveau praticien </h3>";

$pediatrie = $specialiteRepository->findOneBy(['libelle' => 'pédiatrie']);

$nouveauId = Uuid::uuid4()->toString();
echo "Nouveau ID généré pour le praticien : " . $nouveauId . "<br>";
$nouveauPraticien = new Praticien(
    id: $nouveauId,
    nom: "Martin",
    rpps_id: "1010101010",
    prenom: "Alice",
    titre: "Dr.",
    ville: "Nancy",
    email: "alice.martin@test.fr",
    telephone: "0606060606",
    organisation: "0",
    accepte_nouveau_patient: "1",
    specialite: $pediatrie,
    structure: null
);

$entityManager->persist($nouveauPraticien);

try {
    $entityManager->flush();
    echo "Succès ! Le praticien <b>" . $nouveauPraticien->getNom() . "</b> (ID: $nouveauId) a été enregistré en base.";
} catch (Exception $e) {
    echo "Erreur lors de l'enregistrement : " . $e->getMessage();
}