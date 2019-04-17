<?php
namespace Ecommerce\EcommerceBundle\Twig\Extension;

class TvaExtension extends \Twig_Extension
{
    public function getFilters()//obligatoire pour nommer le filtre dans twig
    {
        return array(new \Twig_SimpleFilter('tva', array($this,'calculTva')));//on nomme simplement le filtre que l on va utilisé dans twig. On le nome tva et on lui associe la méthode calculTva
    }
    
    function calculTva($prixHT,$tva)//attention il y a un ordre pour les paramètres. on définit les parametre de la vue : le premier parametre qui est produit.prix et le deuxieme parametre qui est produit.tva.muliplicate
    {
        $prixTTC = round($prixHT / $tva,2);
        
        return $prixTTC;
    }
    
    public function getName()
    {
        return 'tva_extension';
    }
}

