<?php 

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Media;

class MediaData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('http://aaems.org/wp-content/uploads/2014/07/l%C3%A9gumes.jpg');
        $media1->setAlt('Legumes');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setPath('https://tse2.mm.bing.net/th?id=OIP.Mbde574275492c4d091fbf911a39a1627o0&pid=15.1');
        $media2->setAlt('Fruits');
        $manager->persist($media2);

        $media3 = new Media();
        $media3->setPath('http://www.niffylux.com/components/com_virtuemart/shop_image/product/Tomate__7_4b71e7e13f85b.jpg');
        $media3->setAlt('Tomate');
        $manager->persist($media3);

        $media4 = new Media();
        $media4->setPath('https://tse1.mm.bing.net/th?id=OIP.Ma38c2c24b8a9d6105ec1545e0d316b2bH0&pid=15.1');
        $media4->setAlt('Aubergine');
        $manager->persist($media4);

        $media5 = new Media();
        $media5->setPath('http://2.bp.blogspot.com/-eSdeIXiVevY/UHGVR7S2QTI/AAAAAAAAEBU/tPwAzAYMQj8/s1600/Concombre-1.jpg');
        $media5->setAlt('Concombre');
        $manager->persist($media5);

        $media6 = new Media();
        $media6->setPath('http://img0.mxstatic.com/wallpapers/50c584062ed1e5c1925b22c0996d1d07_large.jpeg');
        $media6->setAlt('Banane');
        $manager->persist($media6);

        $media7 = new Media();
        $media7->setPath('https://tse1.mm.bing.net/th?id=OIP.M3b7948d5e6c8ad4f0f91b78b88cd9cc9o0&pid=15.1');
        $media7->setAlt('Abricot');
        $manager->persist($media7);

        $media8 = new Media();
        $media8->setPath('http://jlggb.net/blog2/wp-content/uploads/2011/06/peche-fond-blanc.jpg');
        $media8->setAlt('Pêche');
        $manager->persist($media8);
        
        $media9 = new Media();
        $media9->setPath('http://www1.alliancefr.com/wp-content/uploads/bqimages/avo.jpg');
        $media9->setAlt('Avocat');
        $manager->persist($media9);
        
        $media10 = new Media();
        $media10->setPath('http://handmelonfarm.com/wp-content/uploads/2013/04/open-melon.jpg');
        $media10->setAlt('Melon');
        $manager->persist($media10);
        
        $media11 = new Media();
        $media11->setPath('http://www.metro.ca/userfiles/image/articles/citron/page-citron-bloc3.jpg');
        $media11->setAlt('Citron');
        $manager->persist($media11);

        $manager->flush();

        $this->addReference('media1', $media1);
        $this->addReference('media2', $media2);
        $this->addReference('media3', $media3);
        $this->addReference('media4', $media4);
        $this->addReference('media5', $media5);
        $this->addReference('media6', $media6);
        $this->addReference('media7', $media7);
        $this->addReference('media8', $media8);
        $this->addReference('media9', $media9);
        $this->addReference('media10', $media10);
        $this->addReference('media11', $media11);
    }

    public function getOrder(){
    	return 1;
    }
}