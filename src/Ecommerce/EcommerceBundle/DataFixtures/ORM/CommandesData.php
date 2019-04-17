<?php
namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Commandes;

class CommandesData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $commande1 = new Commandes();
        $commande1->setUtilisateur($this->getReference('utilisateur1'));
        $commande1->setValider('1');
        $commande1->setDate(new \DateTime());
        $commande1->setReference('1');
        $commande1->setCommande(array('0' => array('1' => '2'),
                                      '1' => array('2' => '1'),
                                      '2' => array('4' => '5')
                                ));
      
        $manager->persist($commande1);
        
        $commande2 = new Commandes();
        $commande2->setUtilisateur($this->getReference('utilisateur2'));
        $commande2->setValider('1');
        $commande2->setDate(new \DateTime());
        $commande2->setReference('2');
        $commande2->setCommande(array('0' => array('1' => '1'),
                                      '1' => array('3' => '1'),
                                      '2' => array('6' => '1')
                                ));
        $manager->persist($commande2);
        
        $commande3 = new Commandes();
        $commande3->setUtilisateur($this->getReference('utilisateur1'));
        $commande3->setValider('1');
        $commande3->setDate(new \DateTime());
        $commande3->setReference('1');
        $commande3->setCommande(array('0' => array('1' => '10'),
                                      '1' => array('4' => '6'),
                                      '2' => array('5' => '1')
                                ));
        $manager->persist($commande3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}