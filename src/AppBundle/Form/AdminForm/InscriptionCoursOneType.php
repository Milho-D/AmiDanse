<?php
/**
 * Created by PhpStorm.
 * User: allar
 * Date: 28/04/2017
 * Time: 10:01
 */

namespace AppBundle\Form\AdminForm;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InscriptionCoursOneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class,array(
                'attr' => [
                    'class' => 'form-control',
                ],

                'class' => 'AppBundle:Type',
                'choice_label'=> 'nomType',
            ));

    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {

    }
}