<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Form\RechercheType;
use Ecommerce\EcommerceBundle\Entity\Categories;
use Ecommerce\EcommerceBundle\Entity\Produits;

class ProduitsController extends Controller
{
    
    public function produitsAction(Categories $categorie=null)
    {
        
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        
        if($categorie!=null)
        {
            $findProduits=$em->getRepository('EcommerceBundle:Produits')->byCategorie($categorie);
            
        }
        else
        {
            $findProduits=$em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible'=>1));
            
 
        }
        if($session->has('panier'))
        {
            $panier=$session->get('panier');
        }
        else
        {
            $panier=false;
        }
        
        $countProduitsCat=$em->getRepository('EcommerceBundle:Produits')->countProduitsByCategorie($categorie);
        
        /*$session = $this->getRequest()->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
         */
        
        
        $produits  = $this->get('knp_paginator')->paginate(
            $findProduits,/*la requete*/
            $this->getRequest()->query->get('page', 1)/*page number*/,
            15/*limit per page*/
        );
        
        return $this->render('EcommerceBundle:Produits/layout:produits.html.twig', array('produits'=>$produits,
                                                                                         'panier'=>$panier,
                                                                                         'categorie'=>$categorie,
                                                                                         'countProduitsCat'=>$countProduitsCat,
                                                                                         'findProduits'=>$findProduits
        ));
    }
    
    public function presentationAction($slug)
    {
        $session=$this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        
        if($session->has('panier'))
            $panier=$session->get('panier');
        else
            $panier=false;
        
        $produit=$em->getRepository('EcommerceBundle:Produits')->findOneBySlug($slug);
        
        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');
        
        return $this->render('EcommerceBundle:Produits/layout:presentation.html.twig', array('produit'=>$produit,
                                                                                             'panier'=>$panier));
    }
    
    public function rechercheAction()
    {
        $form=$this->createForm(new RechercheType());
        
        return $this->render('EcommerceBundle:Recherche/modulesUsed:recherche.html.twig', array('form'=>$form->createView()));
    }
    
    public function rechercheTraitementAction(Categories $categorie=null) 
    {
        $form = $this->createForm(new RechercheType());
        
        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $findProduits = $em->getRepository('EcommerceBundle:Produits')->recherche($form['recherche']->getData());
            
            $produits  = $this->get('knp_paginator')->paginate(
            $findProduits,/*la requete*/
            $this->getRequest()->query->get('page', 1)/*page number*/,
            6/*limit per page*/
        );
        } 
        else 
        {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }
        
        $countProduitsCat=$em->getRepository('EcommerceBundle:Produits')->countProduitsByCategorie($categorie);
        
        return $this->render('EcommerceBundle:Produits/layout:produits.html.twig', array('produits' => $produits,
                                                                                         'categorie' => $categorie,
                                                                                         'countProduitsCat'=>$countProduitsCat,
                                                                                         'findProduits'=>$findProduits
        ));
    }
}
