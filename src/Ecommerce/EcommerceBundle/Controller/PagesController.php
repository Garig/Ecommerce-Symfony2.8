<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Contact;
use Ecommerce\EcommerceBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{

    public function contactAction(Request $request){
    	$em=$this->getDoctrine()->getManager();

        $contact=new Contact() ;
     
        $form=$this->createForm(new ContactType(), $contact);

        /*$request=$this->getRequest();*/
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isSubmitted() && $form->isValid() ){
                $contact=$form->getData();

                //$animal->getImage()->Upload();

                $contact->setDate(new \DateTime());
                $em->persist($contact);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Message bien envoyé!');

                //ici le service qui envoie l email quand un objet contact et hydraté
                $this->container->get('emailContact')->emailContact($contact);

                return $this->redirect($this->generateUrl("contact"));
            }
        }

        return $this->render('EcommerceBundle:Pages:contact.html.twig', array('form' => $form->createView()));
    }





}