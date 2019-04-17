<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{
    public function menuAction()
    {
        $em=$this->getDoctrine()->getManager();
        
        $categories=$em->getRepository('EcommerceBundle:Categories')->findAll();
                
        return $this->render('EcommerceBundle:Categories/modulesUsed:menu.html.twig', array('categories'=>$categories));
    }
}
