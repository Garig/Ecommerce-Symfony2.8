<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Form\TestType;

class TestController extends Controller
{
	public function demarrageAction($nom, $prenom)
    {
        $tonton='Jacky';
        $tontons=array('tonton1','tonton2','tonton3');
        return $this->render('EcommerceBundle:Test:demarrage.html.twig', array('nom' => $nom,
        																	  'prenom'=>$prenom,
        																	  'tonton'=>$tonton,
        																	  'tontons' =>$tontons));
    }

	public function testFormulaireAction()
    {
    	$form=$this->createForm(new TestType());

        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);
            var_dump($form->getData());

            $form=$this->createForm(new TestType(), array('email'=>'alexandre@yahoo.fr'));

        }

    	return $this->render('EcommerceBundle:Test:testFormulaire.html.twig', array('form'=>$form->createView()));
    }
}