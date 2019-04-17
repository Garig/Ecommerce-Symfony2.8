<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pages\PagesBundle\Entity\Pages;
use Pages\PagesBundle\Form\PagesType;

/**
 * Pages controller.
 *
 */
class PagesAdminController extends Controller
{
    /**
     * Lists all Pages entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('PagesBundle:Administration/Pages/layout:index.html.twig', array(
            'pages' => $pages,
        ));
    }
    
    public function softDelAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        
        $entities = $em->getRepository('PagesBundle:Pages')->findByRemove();
        return $this->render('PagesBundle:Administration/Pages/layout:softDel.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    public function restoreAction($id) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        
        $entity = $em->getRepository('PagesBundle:Pages')->find($id);
        $entity->setDeletedAt(null);
        $em->persist($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('adminPages_index'));
    }

    /**
     * Creates a new Pages entity.
     *
     */
    public function newAction()
    {
        $page = new Pages();
        $form = $this->createForm('Pages\PagesBundle\Form\PagesType', $page);

        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $page=$form->getData();

                //$animal->getImage()->Upload();

                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Page bien ajoutée !');

            return $this->redirectToRoute('adminPages_show', array('id' => $page->getId()));
            }
        
        }

        return $this->render('PagesBundle:Administration/Pages/layout:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pages entity.
     *
     */
    public function showAction(Pages $page)
    {

        return $this->render('PagesBundle:Administration/Pages/layout:show.html.twig', array(
            'page' => $page,
        ));
    }

    /**
     * Displays a form to edit an existing Pages entity.
     *
     */
    public function editAction(Pages $page)
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $form = $this->createForm(new PagesType(), $page);

        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $page=$form->getData();
                $em->persist($page);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info','Page bien modifiée !');
                
            return $this->redirectToRoute('adminPages_index');
            }
        }

        return $this->render('PagesBundle:Administration/Pages/layout:edit.html.twig', array(
            'id'   => $page->getId(),
            'page' => $page,
            'form' => $form->createView(),
        ));
        
    }


    public function deleteAction(Pages $page)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($page);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info','Page bien supprimée !');

        return $this->redirectToRoute('adminPages_index');
    }

}
