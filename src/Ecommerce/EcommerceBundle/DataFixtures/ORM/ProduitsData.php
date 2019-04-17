<?php 

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Produits;

class ProduitsData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $produit1= new Produits();
        $produit1->setCategorie($this->getReference('categorie1'));
        $produit1->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit1->setDisponible('1');
        $produit1->setImage($this->getReference('media3'));
        $produit1->setNom('Tomate');
        $produit1->setPrix('3.20');
        $produit1->setTva($this->getReference('tva2'));
        $manager->persist($produit1);

        $produit2= new Produits();
        $produit2->setCategorie($this->getReference('categorie1'));
        $produit2->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit2->setDisponible('1');
        $produit2->setImage($this->getReference('media4'));
        $produit2->setNom('Aubergine');
        $produit2->setPrix('3.30');
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);

        $produit3= new Produits();
        $produit3->setCategorie($this->getReference('categorie1'));
        $produit3->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit3->setDisponible('1');
        $produit3->setImage($this->getReference('media5'));
        $produit3->setNom('Concombre');
        $produit3->setPrix('3.10');
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);

        $produit4= new Produits();
        $produit4->setCategorie($this->getReference('categorie2'));
        $produit4->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit4->setDisponible('1');
        $produit4->setImage($this->getReference('media6'));
        $produit4->setNom('Banane');
        $produit4->setPrix('3.40');
        $produit4->setTva($this->getReference('tva1'));
        $manager->persist($produit4);

        $produit5= new Produits();
        $produit5->setCategorie($this->getReference('categorie2'));
        $produit5->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit5->setDisponible('1');
        $produit5->setImage($this->getReference('media7'));
        $produit5->setNom('Abricot');
        $produit5->setPrix('3.80');
        $produit5->setTva($this->getReference('tva2'));
        $manager->persist($produit5);

        $produit6= new Produits();
        $produit6->setCategorie($this->getReference('categorie2'));
        $produit6->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit6->setDisponible('1');
        $produit6->setImage($this->getReference('media8'));
        $produit6->setNom('Pêche');
        $produit6->setPrix('3.70');
        $produit6->setTva($this->getReference('tva2'));
        $manager->persist($produit6);
        
        $produit7= new Produits();
        $produit7->setCategorie($this->getReference('categorie2'));
        $produit7->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit7->setDisponible('1');
        $produit7->setImage($this->getReference('media9'));
        $produit7->setNom('Avocat');
        $produit7->setPrix('3.90');
        $produit7->setTva($this->getReference('tva2'));
        $manager->persist($produit7);
        
        $produit8= new Produits();
        $produit8->setCategorie($this->getReference('categorie2'));
        $produit8->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit8->setDisponible('1');
        $produit8->setImage($this->getReference('media10'));
        $produit8->setNom('Melon');
        $produit8->setPrix('4.50');
        $produit8->setTva($this->getReference('tva2'));
        $manager->persist($produit8);
        
        $produit9= new Produits();
        $produit9->setCategorie($this->getReference('categorie2'));
        $produit9->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $produit9->setDisponible('1');
        $produit9->setImage($this->getReference('media11'));
        $produit9->setNom('Citron');
        $produit9->setPrix('3.80');
        $produit9->setTva($this->getReference('tva2'));
        $manager->persist($produit9);

        $manager->flush();

    }

    public function getOrder(){
        return 4;
    }
}