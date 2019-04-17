<?php
namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\Produits;

class CommandesAdminController extends Controller
{
    public function commandesAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('EcommerceBundle:Commandes')->findBy(array('valider' => 1));
        
        return $this->render('EcommerceBundle:Administration:Commandes/layout/index.html.twig', array('factures' => $factures));
    }
    
    public function facturesPDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
                                                                                    'valider' => 1,
                                                                                    'id' => $id)) ;
        if (!$facture ) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est servenue');
            return $this->redirect($this->generateUrl('factures'));
        } 
        
        $html = $this->renderView('EcommerceBundle:Administration/commandes/layout:facturePDF.html.twig', array('facture'=>$facture));
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


