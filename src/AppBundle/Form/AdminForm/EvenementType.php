<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 23:38
 */

namespace AppBundle\Form\AdminForm;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEvenement', TextType::class,[
                'attr' => [
                    'class'=> 'form-control',
                ]])
            ->add('lieuEvenement', TextType::class, [
                'attr' => [
                    'class'=> 'form-control',
            ]])
            ->add('dateEvenement', DateTimeType::class,[
                'attr' => [
                    'class' => 'form-control input-group date',
                ]])
            ->add('image', FileType::class,[
                'attr' => [
                    'class'=> 'form-control',
                ],
                'required' => false
            ]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Evenement'
        ]);
    }
}