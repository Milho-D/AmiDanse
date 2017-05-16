<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 23:29
 */

namespace AppBundle\Form\AdminForm;

use AppBundle\Entity\Courant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypedanseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomType', TextType::class,
                [
                    'attr' => [
                        'class'=> 'form-control',
                    ]])
            ->add('courants', EntityType::class, [
                'class' => 'AppBundle:Courant',
                'choice_label' => 'nomCourant',
                    'attr' => [
                        'class'=> 'form-control',
                    ],
                'multiple'=>true,
            ])
            ->add('video', TextType::class,
                [
                    'required'=> false,
                    'label' => 'Lien vers une video (Youtube)',
                    'attr' => [
                        'class'=> 'form-control',
                    ]])
            ->add('referent', EntityType::class, [
                    'attr' => [
                        'class'=> 'form-control',
                    ],
                'class' => 'UserBundle\Entity\User',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.estProfesseur = true')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => function ($user) {
                    return $user->getNom().' '.$user->getPrenom();
                }
            ]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Type'
        ]);
    }
}