<?php

namespace AppBundle\Form\AdminForm;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CoursType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('nomCours', TextType::class, array(
                    'label' => 'Nom du cours :',
                    'attr'=> [
                        'class' => 'form-control'
                    ]
                ))
                ->add('animateurs', EntityType::class, array(
                    'class' => 'UserBundle:User',
                    'label' => 'Nom de l\'animateur :',
                    'attr'=> [
                        'class' => 'form-control'
                    ],
                    'group_by'=> function ($val, $key, $index){
                        if ($val->getEstResponsable()){
                            return 'Responsable';
                        } elseif ($val->getEstProfesseur()) {
                            return 'Professeurs';
                        } else {
                            return 'Danseurs';
                        }
                    },
                    'choice_label' => function ($val){
                        return $val->getNom().' '.$val->getPrenom();
                    },
                    'multiple' => true,
                ))
                ->add('type', EntityType::class, array(
                    'class' => 'AppBundle:Type',
                    'attr'=> [
                        'class' => 'form-control'
                    ],
                    'choice_label' => 'nomType'
                ))
                ->add('salle', EntityType::class, array(
                    'label' => 'Salle :',
                    'class' => 'AppBundle:Salle',
                    'attr'=> [
                        'class' => 'form-control'
                    ],
                    'choice_label' => 'nomSalle',
                    'expanded' => false,
                ))
                ->add('niveau', EntityType::class, array(
                    'label' => 'niveau :',
                    'class' => 'AppBundle:Niveau',
                    'attr'=> [
                        'class' => 'form-control',
                    ],
                    'choice_label' => 'nomNiveau'
                ))
                ->add('dateDebut', DateTimeType::class, array(
                    'years' => range(date('Y'), date('Y')+10),
                    'hours' => range(10,23),
                    'minutes' => array(0,30),
                    'widget' => 'choice',
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                    'attr'=> [
                        'class' => 'form-control input-group date',
                    'id' => 'datetimepicker1',
                    ],
                    'label' => 'Debut du cours :',
                ))
                ->add('duree', IntegerType::class,array(
                    'data' => 90,
                    'mapped' => false,
                    'attr' =>[
                        'min'=> 90,
                        'step' => 30,
                        'class'=> 'form-control'
                    ],
                    'label' => 'Durée du cours (minutes)'
                ))
                ->add('evenements', EntityType::class, array(
                    'class' => 'AppBundle:Evenement',
                    'attr' => [
                        'class'=> 'form-control',
                    ],
                    'choice_label' => 'nomEvenement',
                    'multiple' => true,
                    'required' => false
                ));
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Cours'
        ]);
    }
}
