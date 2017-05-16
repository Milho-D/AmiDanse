<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 19:10
 */

namespace AppBundle\Form\AdminForm;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomNiveau', TextType::class,[
                'attr' => [
                    'class'=> 'form-control',
                ]]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Niveau'
        ]);
    }
}