<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 30/04/2017
 * Time: 20:22
 */

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe',
                    'attr' => [
                        'class'=> 'form-control',
                        'type' => 'password',
                    ]
                ),
                'second_options' => array('label' => 'Retapez votre mot de passe',
                    'attr' => [
                        'class'=> 'form-control',
                        'type' => 'password',
                    ])));

    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }
}