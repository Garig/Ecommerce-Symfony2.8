<?php

namespace Ecommerce\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommandesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandesRepository extends EntityRepository
{
   
    public function byFacture($utilisateur)
    {
        $qb = $this->createQueryBuilder('u')
                ->select('u')
                ->where('u.utilisateur = :utilisateur')
                ->andWhere('u.valider = 1')
                ->andWhere('u.reference != 0')
                ->orderBy('u.id')
                ->setParameter('utilisateur', $utilisateur);
        
        return $qb->getQuery()->getResult();
    }
    
    public function byDateCommand($date)
    {
        $qb = $this->createQueryBuilder('u')
                ->select('u')
                ->where('u.date > :date')
                ->andWhere('u.valider = 1')
                ->orderBy('u.id')
                ->setParameter('date', $date);
        
        return $qb->getQuery()->getResult();
    }

}
