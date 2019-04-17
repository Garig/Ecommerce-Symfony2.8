<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecommerce\EcommerceBundle\Entity\Categories;
use Ecommerce\EcommerceBundle\Form\CategoriesType;

/**
 * Categories controller.
 *
 */
class CategoriesAdminController extends Controller
{
    /**
     * Lists all Categories entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();

        return $this->render('EcommerceBundle:Administration/Categories/layout:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new Categories entity.
     *
     */
    public function newAction()
    {
        $categorie = new Categories();
        $form = $this->createForm(new CategoriesType(), $categorie);

        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $categorie=$form->getData();

                //$animal->getImage()->Upload();

                $em->persist($categorie);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Catégorie bien ajoutée !');

            return $this->redirectToRoute('adminCategories_show', array('id' => $categorie->getId()));
            }
        
        }

        return $this->render('EcommerceBundle:Administration/Categories/layout:new.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categories entity.
     *
     */
    public function showAction(Categories $categorie)
    {

        return $this->render('EcommerceBundle:Administration/Categories/layout:show.html.twig', array(
            'categorie' => $categorie,
        ));
    }

    /**
     * Displays a form to edit an existing Categories entity.
     *
     */
    public function editAction(Categories $categorie)
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $form = $this->createForm(new CategoriesType(), $categorie);

        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $categorie=$form->getData();
                $em->persist($categorie);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Catégorie bien modifiée !');
                
            return $this->redirectToRoute('adminCategories_index');
            }
        }

        return $this->render('EcommerceBundle:Administration/Categories/layout:edit.html.twig', array(
            'id'   => $categorie->getId(),
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
        
    }


    public function deleteAction(Categories $categorie)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($categorie);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info','Catégorie bien supprimée !');

        return $this->redirectToRoute('adminCategories_index');
    }
}
