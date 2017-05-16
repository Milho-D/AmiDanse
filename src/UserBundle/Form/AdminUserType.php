<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 19:48
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                ]])
            ->add('prenom', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                ]])
            ->add('sexe', ChoiceType::class, array(
                    'attr' => [
                        'class' => 'form-control',
                    ],
                'choices'  => array(
                    'Femme' => 'Femme',
                    'Homme' => 'Homme'
                )))
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' => 'form-control',
                ]])
            ->add('username', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                ]])
            ->add('picture', FileType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('etat', CheckboxType::class, array(
                'attr' => [
                    'class' => 'checkbox'
                ],
                'required' => false,
            ))
            ->add('statut', ChoiceType::class, array(
                    'attr' => [
                        'class' => 'form-control',
                    ],
                'choices'  => array(
                    'Interne' => 'interne',
                    'Externe' => 'externe',
                    '-'=>null
                )))
            ->add('estProfesseur', CheckboxType::class, array(
                'label' => 'Est professeur  ',
                'attr' => [
                    'class' => 'checkbox'
                ],
                'required' => false,
            ))
            ->add('estResponsable', CheckboxType::class, array(
                'attr' => [
                    'class' => 'checkbox',
                ],
                'required' => false,
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'attr' => [
                    'class'=> 'form-control',
                    'type' => 'password',
                ],
                'first_options'  => array('label' => 'Password',
                    'attr'=> [
                        'class'=>'form-control'
                    ]),
                'second_options' => array('label' => 'Repeat Password',
                    'attr'=> [
                        'class'=>'form-control'
                    ]),
            ))
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User'
        ]);
    }
}