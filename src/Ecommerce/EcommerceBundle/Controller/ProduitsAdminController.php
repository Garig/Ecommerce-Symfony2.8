<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ecommerce\EcommerceBundle\Entity\Produits;
use Ecommerce\EcommerceBundle\Form\ProduitsType;

/**
 * Produits controller.
 *
 * @Route("/adminProduits")
 */
class ProduitsAdminController extends Controller
{
    /**
     * Lists all Produits entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('EcommerceBundle:Produits')->findAll();

        return $this->render('EcommerceBundle:Administration/Produits/layout:index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Creates a new Produits entity.
     *
     */
    public function newAction()
    {
        $produit = new Produits();
        $form = $this->createForm(new ProduitsType(), $produit);

        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $produit=$form->getData();

                //$animal->getImage()->Upload();

                $em->persist($produit);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Produit bien ajouté !');

            return $this->redirectToRoute('adminProduits_show', array('id' => $produit->getId()));
            }
        
        }

        return $this->render('EcommerceBundle:Administration/Produits/layout:new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Produits entity.
     *
     */
    public function showAction(Produits $produit)
    {

        return $this->render('EcommerceBundle:Administration/Produits/layout:show.html.twig', array(
            'produit' => $produit,
        ));
    }

    /**
     * Displays a form to edit an existing Produits entity.
     *
     */
    public function editAction(Produits $produit)
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $form = $this->createForm(new ProduitsType(), $produit);

        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $produit=$form->getData();
                $em->persist($produit);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Produit bien modifié !');
                
            return $this->redirectToRoute('adminProduits_index');
            }
        }

        return $this->render('EcommerceBundle:Administration/Produits/layout:edit.html.twig', array(
            'id'   => $produit->getId(),
            'produit' => $produit,
            'form' => $form->createView(),
        ));
        
    }


    public function deleteAction(Produits $produit)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($produit);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info','Produit bien supprimé !');

        return $this->redirectToRoute('adminProduits_index');
    }

}
