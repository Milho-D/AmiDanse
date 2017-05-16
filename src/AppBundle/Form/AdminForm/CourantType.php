<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 23:38
 */

namespace AppBundle\Form\AdminForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CourantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCourant', TextType::class,[
                'attr' => [
                    'class'=> 'form-control',
                ]])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image (format : 380px * 665px)',
                'attr' => [
                    'class'=> 'form-control',
                    ]
            ]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Courant'
        ]);
    }
}