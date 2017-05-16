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

class InscriptionCoursTwoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $type = $option['data']['type'];
        $user = $option['data']['user'];

        $now = new \DateTime();
        $datetime = $now->format('Y-m-d H:i:s');

        $builder
            ->add('cours', EntityType::class, [
                'attr' => [
                    'class'=> 'form-control'
                ],
                'class' => 'AppBundle:Cours',
                'query_builder' => function (EntityRepository $er) use ($type, $user, $datetime){
                    return $er->createQueryBuilder('c')
                        ->where(':type = c.type')
                        ->andWhere(':danseur NOT MEMBER OF c.danseurs')
                        ->andWhere('c.dateDebut > :date')
                        ->setParameters(['type' => $type , 'danseur' => $user, 'date' => $datetime]);
                },
                'choice_label' => function ($value){
                    return $value->getNomCours().' début le '.$value->getDateDebut()->format('d/m/Y à H:i').' fin le '.$value->getDateFin()->format('d/m/Y à H:i');
                }
            ]);
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {

    }
}