<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Entity\Commandes;

class PanierController extends Controller
{
    public function menuAction()
    {
        $session=$this->getRequest()->getSession();
        //var_dump($session->get('panier'));
        if(!$session->has('panier'))
            $articles=0;
        else
            $articles=count($session->get('panier'));
        
        return $this->render('EcommerceBundle:Panier/modulesUsed:panier.html.twig', array('articles'=>$articles,));
        
    }
    public function ajouterAction($id)
    {
        $session=$this->getRequest()->getSession();
        
        if(!$session->has('panier')) $session->set('panier', array());//l'équivalent d'un isset en php sinon on set une session que l on appelle panier et on lui passe un array vide
        //$session=[ID PRODUIT]=>[QTE]
        $panier=$session->get('panier');
        
        if (array_key_exists($id, $panier)){//si l id du produit est deja présent dans notre variable session alors on lui attribue la nouvelle qte
            if($this->getRequest()->query->get('qte') !=null) $panier[$id]=$this->getRequest()->query->get('qte');//la ça veut dire qu on passe par la page présentation ou la page panier et qu on attribue une nouvelle quantité
            $this->get('session')->getFlashBag()->add('success','Quantité modifiée avec succès'); 
        }else{
            if($this->getRequest()->query->get('qte') !=null) $panier[$id]=$this->getRequest()->query->get('qte');//sinon si l id du produit n est pas présent dans notre panier c a d qu on passe par la page presentation, on lui attribue la qte désiré
            else $panier[$id]=1;////sinon si l id du produit n est pas présent dans notre panier et qu on passe par la page produits alors la qte est égale à 1
            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }
        
        $session->set('panier',$panier);
                
        return $this->redirect($this->generateUrl('panier'));
    }
    
    public function supprimerAction($id)
    {
        $session=$this->getRequest()->getSession();
        $panier=$session->get('panier');
        
        if(array_key_exists($id, $panier))
        {
            unset ($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }
        
        return $this->redirect($this->generateUrl('panier'));
    }
    
    public function panierAction()
    {
        $session=$this->getRequest()->getSession();
        //$session->remove('panier');
        //die();
        
        if(!$session->has('panier')) $session->set('panier', array());
        
        //var_dump($session->get('panier'));
        //die();
        
        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        
        
        return $this->render('EcommerceBundle:Panier/layout:panier.html.twig', array('produits'=>$produits,
                                                                                     'panier'=>$session->get('panier')));
    }

    public function livraisonAction()
    {
        $utilisateur=$this->container->get('security.context')->getToken()->getUser();//on récupère l'utilisateur
        $entity=new UtilisateursAdresses();
        $form=$this->createForm(new UtilisateursAdressesType(), $entity);
        
        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()){
                $em=$this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);//on peut le faire car bidirectionnel
                $em->persist($entity);
                $em->flush();
                
                return $this->redirect($this->generateUrl('livraison'));
            }
        }
        
        return $this->render('EcommerceBundle:Panier/layout:livraison.html.twig', array('utilisateur'=>$utilisateur,
                                                                                        'form'=>$form->createView()));
    }
    
    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($id);
        
        if ($this->container->get('security.context')->getToken()->getUser() != $entity->getUtilisateur() || !$entity)
            return $this->redirect ($this->generateUrl ('livraison'));
        
        $em->remove($entity);
        $em->flush();
        
        return $this->redirect ($this->generateUrl ('livraison'));
    }

    public function setLivraisonOnSession()
    {
        $session=$this->getRequest()->getSession();
        
       //si la variable adresse n existe pas dans la session on la créé et on lui passe un array
        if (!$session->has('adresse')) $session->set('adresse', array());
        //si elle existe dans la session on récupère la variable adresse en faisant un get('adresse')
        $adresse=$session->get('adresse');
        //on va récupérer nos valeurs passé dans le formulaire avec getRequest()
        if ($this->getRequest()->request->get('livraison') != null && $this->getRequest()->request->get('facturation') != null)
        {
            $adresse['livraison']=$this->getRequest()->request->get('livraison');
            $adresse['facturation']=$this->getRequest()->request->get('facturation');   
        }else{
            return $this->redirect($this->generateUrl('validation'));
        }
        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }
    
    public function validationAction()
    {
        if ($this->getRequest()->getMethod() == 'POST')
        $this->setLivraisonOnSession ();
        
        $session=$this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $prepareCommande=$this->forward('EcommerceBundle:Commandes:prepareCommande');//on fait appel depuis notre panier à notre méthode prepareCommandeAction qui elle-meme fait appel a la méthode facture()
        $commande=$em->getRepository('EcommerceBundle:Commandes')->find($prepareCommande->getContent());//Vu que la méthode précédente nous retourne un id, on passe l'id de la commande à notre entité Commandes. Comme ça on peut récupérer toutes nos informations qui sont stockées en base
        
        /*
        $session=$this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $adresse=$session->get('adresse');
        
        $produits=$em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        $livraison=$em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $facturation=$em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);
        */
        
        //var_dump($adresse);
        //die();
        
        //var_dump($commande);
        //die();
        
        return $this->render("EcommerceBundle:Panier/layout:validation.html.twig", array('commande'=>$commande));
        
        /*return $this->render("EcommerceBundle:Panier/layout:validation.html.twig", array('produits'=>$produits,
                                                                                         'livraison'=>$livraison,
                                                                                         'facturation'=>$facturation,
                                                                                         'panier'=>$session->get('panier')));*/
        //on a pas été cherché le panier mais comme on a accès aux session on peut faire un $session->get('panier')
    }
}
