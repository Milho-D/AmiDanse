<?php
/**
 * Created by PhpStorm.
 * User: allar
 * Date: 05/05/2017
 * Time: 14:34
 */

namespace AppBundle\Form\AdminForm;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noteAvis', ChoiceType::class, [
                'choices'=> [1=>1,2=>2,3=>3,4=>4,5=>5],
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('messageAvis', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Avis'
        ]);
    }
}