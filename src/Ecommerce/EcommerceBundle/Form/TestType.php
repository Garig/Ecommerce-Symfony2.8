<?php

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/*use Symfony\Component\OptionsResolver\OptionsResolver;*/

class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email','email')
            ->add('nom', 'text', array('required'=>false))
            ->add('prenom','text')
            ->add('sexe','choice', array('choices'=>array('0'=>'homme',
                                                          '1'=>'femme',
                                                          '2'=>'autre'),'expanded'=>false))
            ->add('contenu','textarea')
            ->add('utilisateurs','entity', array('class'=>'Utilisateurs\UtilisateursBundle\Entity\Utilisateurs',
                                               'property'=>'username',
                                               'multiple'=>false,
                                               'expanded'=>false))
            ->add('date','datetime')
            ->add('pays','country')
            ->add('envoyer','submit')
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    /*
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecommerce\EcommerceBundle\Entity\Produits'
        ));
    }
    */

        /**
     * @return string
     */
    public function getName()
    {
        return 'ecommerce_ecommerceBundle_test';
    }
}
