<?php
namespace Ecommerce\EcommerceBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EmailMerci 
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function emailMerci($commande)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre commande')
                ->setFrom(array('contact@mypanier.fr' => "MyPanier.fr"))
                ->setTo($commande->getUtilisateur()->getEmailCanonical())
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('EcommerceBundle:SwiftLayout:validationCommande.html.twig',array('utilisateur' => $commande->getUtilisateur())));
        
        $this->container->get('mailer')->send($message);
    }
}

