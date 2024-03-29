<?php

namespace Ecommerce\EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProduitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitsRepository extends \Doctrine\ORM\EntityRepository //on se place dans ProduitsRepository car on veut trier des produits
{
    public function findArray($array)
    {
         $qb = $this->createQueryBuilder('u')
                    ->select('u')
                    ->where('u.id IN (:array)')
                    ->setParameter('array', $array);
        return $qb->getQuery()->getResult();
    }
    
    public function byCategorie($categorie)
    {
         $qb = $this->createQueryBuilder('u')//l alias correspond a produits car on est dans produits
                    ->select('u')//on selectionne produits
                    ->where('u.categorie = :categorie')//heuresement que j avais mis un s à u.categories//on fait correspondre categorie de produits à la catégorie passé en paramètre
                    ->andWhere('u.disponible = 1')//si tu mets 0 ya rien qui s affiche
                    ->orderBy('u.id')//tu peux mettre 'u.nom' ça sera par ordre alphabétique
                    ->setParameter('categorie', $categorie);//obligatoire pour spécifier le paramètre
        return $qb->getQuery()->getResult();
    }
    
    public function recherche($chaine)
    {
         $qb = $this->createQueryBuilder('u')
                    ->select('u')
                    ->where('u.nom like :chaine')
                    ->andWhere('u.disponible = 1')
                    ->orderBy('u.id')
                    ->setParameter('chaine', '%'.$chaine.'%');
        return $qb->getQuery()->getResult();
    }
        
    public function countProduitsByCategorie($categorie)
    {
         $qb = $this->createQueryBuilder('u')//l alias correspond a produits car on est dans produits
                    ->select('COUNT(u)')//on selectionne produits
                    ->where('u.categorie = :categorie')//heuresement que j avais mis un s à u.categories//on fait correspondre categorie de produits à la catégorie passé en paramètre
                    ->andWhere('u.disponible = 1')//si tu mets 0 ya rien qui s affiche
                    ->setParameter('categorie', $categorie);//obligatoire pour spécifier le paramètre
        return $qb->getQuery()->getSingleScalarResult();
    }
}
