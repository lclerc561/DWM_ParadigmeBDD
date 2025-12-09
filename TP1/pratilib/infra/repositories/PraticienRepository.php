<?php

namespace pratilib\infra\repositories;

use Doctrine\ORM\EntityRepository;

class PraticienRepository extends EntityRepository
{
    public function findBySpecialiteMotCle(string $motCle)
    {
        $dql = 'SELECT p, s 
            FROM pratilib\domain\entities\Praticien p 
            JOIN p.specialite s 
            WHERE s.libelle LIKE :motCle 
            OR s.description LIKE :motCle';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('motCle', '%' . $motCle . '%');

        return $query->getResult();
    }

    public function findBySpecialiteAndPaiement(string $nomSpecialite, string $moyenPaiement)
    {
        $dql = 'SELECT p 
                FROM pratilib\domain\entities\Praticien p
                JOIN p.specialite s
                JOIN p.moyensPaiement mp
                WHERE s.libelle = :specialite
                AND mp.libelle = :paiement';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('specialite', $nomSpecialite);
        $query->setParameter('paiement', $moyenPaiement);

        return $query->getResult();
    }
}
