<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function menuAction()
    {
        $em=$this->getDoctrine()->getManager();
        
        $pages=$em->getRepository('PagesBundle:Pages')->findAll();
                
        return $this->render('PagesBundle:Pages/modulesUsed:Menu.html.twig', array('pages'=>$pages));
    }
    
    public function pageAction($slug)
    {
        $em=$this->getDoctrine()->getManager();
        
        $page=$em->getRepository('PagesBundle:Pages')->findOneBySlug($slug);
        
        if (!$page) throw $this->createNotFoundException ('La page n\'a pas été trouvé');

        return $this->render('PagesBundle:Pages/layout:pages.html.twig', array('page'=>$page));
    }
}
