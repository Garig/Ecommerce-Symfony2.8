<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\Produits;

class CommandesController extends Controller
{
    public function facture()
    {
        //on initialise tout ce qu'on a besoin
        $em = $this->getDoctrine()->getManager();
        $generator = $this->container->get('security.secure_random');//pour générer un token
        $session = $this->getRequest()->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;
        $totalTVA = 0;
        
        $facturation = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);//on va chercher tout ce que contient l adresse de facturation pour pouvoir les stocker plus bas
        $livraison = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);//on va chercher tout ce que contient l adresse de facturation pour pouvoir les stocker plus bas
        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        
        foreach($produits as $produit)
        {
            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;//il met += car au debut totalHT c est 0 c est tout; c est pour etre sur que ça repart de 0
            
            //on s'occupe de tout ce qui est tva : on créer un tableau pour la tva
            if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
                //si ya qu un seul article
                $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
            else
                //si ya plusieurs articles
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);
                //on rajoute la valeur de la tva a chaque fois que l on fait un tour de boucle du foreach
            
            $totalTVA += round($prixTTC - $prixHT,2);//il met += car au debut totalTVA c est 0 c est tout; c est pour etre sur que ça repart de 0
            
            //on s'occupe de tout ce qui est produit
            $commande['produit'][$produit->getId()] = array('image' => $produit->getImage(),
                                                            'reference' => $produit->getNom(),
                                                            'quantite' => $panier[$produit->getId()],
                                                            'prixHT' => round($produit->getPrix(),2),
                                                            'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(),2));
        }  
        
        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
                                    'nom' => $livraison->getNom(),
                                    'telephone' => $livraison->getTelephone(),
                                    'adresse' => $livraison->getAdresse(),
                                    'cp' => $livraison->getCp(),
                                    'ville' => $livraison->getVille(),
                                    'pays' => $livraison->getPays(),
                                    'complement' => $livraison->getComplement());
        $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
                                    'nom' => $facturation->getNom(),
                                    'telephone' => $facturation->getTelephone(),
                                    'adresse' => $facturation->getAdresse(),
                                    'cp' => $facturation->getCp(),
                                    'ville' => $facturation->getVille(),
                                    'pays' => $facturation->getPays(),
                                    'complement' => $facturation->getComplement());
        
        $commande['prixHT'] = round($totalHT,2);//on récupère le totalHT, on l'arrondi a 2 chiffres après la virgule
        $commande['prixTTC'] = round($totalHT + $totalTVA,2);//on récupère le totalTTC, on l'arrondi a 2 chiffres après la virgule
        $commande['token'] = bin2hex($generator->nextBytes(20));//on génère un token
        return $commande;//on retourne tout le tableau qu on vient juste de faire
    }
    
    public function prepareCommandeAction()
    {  
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        if (!$session->has('commande'))
            $commande = new Commandes();//soit on instancie une nouvelle commande
        else
            $commande = $em->getRepository('EcommerceBundle:Commandes')->find($session->get('commande'));//soit on récupère la commande actuelle si elle a été modifiée

        //on stocke en base la commande actuelle sachant qu elle n est pas encore validée
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommande($this->facture());

        if (!$session->has('commande')) {
            $em->persist($commande);//on persiste la commande si elle n est pas créé
            $session->set('commande',$commande);
        }

        $em->flush();//si la commande est déja créé, on la flush pour la mettre à jour

        return new Response($commande->getId());//on return l'id de la commande
    }
    
    //Cette methode remplace l'api banque.
    public function validationCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);//facile a comprendre find($id)
        
        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');
        
        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference()); //Service qui ajoute +1 sur la référence
        $em->flush();   
        
        $session = $this->getRequest()->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
        
        //ici le service qui envoie l email de remerciement
        //$this->container->get('EmailMerci')->emailMerci($commande);
        
        //$this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
        $this->get('session')->getFlashBag()->add('success','Paiement non disponible. La commande n\'est pas validée');
        return $this->redirect($this->generateUrl('factures'));
    }
}
