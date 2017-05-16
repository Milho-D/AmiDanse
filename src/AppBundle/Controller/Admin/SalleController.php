<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 18:47
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Salle;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdminForm\SalleType;

class SalleController extends Controller
{
    public function indexAction(){

        $salles = $this->getDoctrine()
            ->getRepository('AppBundle:Salle')
            ->findAll();

        return $this->render('Admin/Salles/index.html.twig',[
            'salles'=>$salles
        ]);
    }

    public function newAction(Request $request){

        $salle = new Salle();
        $salleForm = $this->createForm(SalleType::class, $salle)
            ->add('Ajouter', SubmitType::class, [
                'attr'=> [
                    'class'=>'btn'
                ]
            ]);

        $salleForm->handleRequest($request);

        if ($salleForm->isSubmitted() && $salleForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush($salle);

            return $this->redirectToRoute('app_admin_salles_index');
        }

        return $this->render('Admin/Salles/new.html.twig', [
            'salleForm' => $salleForm->createView()
        ]);
    }

    public function editAction(Request $request, Salle $salle){

        $salleForm = $this->createForm(SalleType::class, $salle)
            ->add('Modifier', SubmitType::class, [
                'attr' => [
                    'class'=> 'btn',
                ]]);

        $salleForm->handleRequest($request);

        if ($salleForm->isSubmitted() && $salleForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_salles_index');
        }

        return $this->render('Admin/Salles/edit.html.twig', [
            'salleForm' => $salleForm->createView()
        ]);
    }

    public function deleteAction(Salle $salle){

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salle);
            $em->flush();
        } catch (DBALException $e) {
            $this->addFlash('danger', 'Cette salle est liée à un ou plusieurs cours');
        }

        return $this->redirectToRoute('app_admin_salles_index');
    }
}