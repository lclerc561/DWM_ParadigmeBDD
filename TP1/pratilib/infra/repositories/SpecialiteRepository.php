<?php

namespace pratilib\infra\repositories;

use Doctrine\ORM\EntityRepository;

class SpecialiteRepository extends EntityRepository
{
    public function findByMotCle(string $motCle)
    {
        $dql = 'SELECT s 
            FROM pratilib\domain\entities\Specialite s 
            WHERE s.libelle LIKE :motCle 
            OR s.description LIKE :motCle';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('motCle', '%' . $motCle . '%');

        return $query->getResult();
    }
}
