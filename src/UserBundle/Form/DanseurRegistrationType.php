<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 19:48
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class DanseurRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('nom', TextType::class,[
        'label' => 'Votre nom',
        'attr' => [
            'class' => 'form-control',
            'placeholder' => 'nom'
        ]
    ])
        ->add('prenom', TextType::class,[
            'label' => 'Votre prénom',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'prénom'
            ]
        ])
        ->add('sexe', ChoiceType::class, array(
            'attr'=> [
                'class' => 'form-control'
            ],
            'choices' => array(
                'Femme' => 'Femme',
                'Homme' => 'Homme'
            )))

        ->add('email', EmailType::class,[
            'label' => 'Votre email',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Email'
            ]
        ])
        ->add('username', TextType::class,[
            'label' => 'Choisissez votre nom d\'utilisateur',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Nom d\'utilisateur'
            ]
        ])
        ->add('picture', FileType::class, [
            'required' => false,
            'label' => 'Choisissez une photo de profil :  ',
            'attr' => [
                'class' => 'form-control',
                'type' => 'file',
                'id' => 'exampleInputFile'
            ]
        ])
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
                ]),
        ));
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }
}