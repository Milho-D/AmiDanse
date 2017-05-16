<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 18:54
 */

namespace AppBundle\Form\AdminForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSalle', TextType::class, [
                'attr' => [
                    'class'=> 'form-control',
                ]])
            ->add('numeroSalle', NumberType::class,
                [
                    'attr' => [
                        'class'=> 'form-control',
                    ]])
            ->add('capaciteSalle', NumberType::class,[
                'attr' => [
                    'class'=> 'form-control',
                ]]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Salle'
        ]);
    }
}