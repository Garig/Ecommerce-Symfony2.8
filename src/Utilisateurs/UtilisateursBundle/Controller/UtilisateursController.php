<?php

namespace Utilisateurs\UtilisateursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UtilisateursController extends Controller
{

    public function indexAction(){

        return $this->render('UtilisateursBundle:layout:moncompte.html.twig');

    }
    
    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('EcommerceBundle:Commandes')->byFacture($this->getUser());
        
        return $this->render('UtilisateursBundle:layout:facture.html.twig', array('factures' => $factures));
    }
    
    public function facturesPDFAction($id)
    {
        /*
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
                                                                                     'valider' => 1,
                                                                                     'id' => $id));
        
        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('factures'));
        }
        
        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');
         
        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');
        
        return $response;
        */
        
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
                                                                                    'valider' => 1,
                                                                                    'id' => $id)) ;
        if (!$facture ) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est servenue');
            return $this->redirect($this->generateUrl('factures'));
        } 
        
        $html = $this->renderView('UtilisateursBundle:layout:facturePDF.html.twig', array('facture'=>$facture));
        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetAuthor('MyPanier.fr');
        $html2pdf->pdf->SetTitle('Facture ');
        $html2pdf->pdf->SetSubject('Facture MyPanier.fr');
        $html2pdf->pdf->SetKeywords('facture,MyPanier.fr');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        return new Response($html2pdf->Output('facture .pdf'), 200, array('Content-Type' => 'application/pdf'));
    }
}
