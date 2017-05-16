<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 19:06
 */

namespace AppBundle\Controller\Admin;


use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Niveau;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdminForm\NiveauType;

class NiveauController extends Controller
{
    public function indexAction(){

        $niveaux = $this->getDoctrine()
            ->getRepository('AppBundle:Niveau')
            ->findAll();

        return $this->render('Admin/Niveaux/index.html.twig',[
            'niveaux'=>$niveaux
        ]);
    }

    public function newAction(Request $request){

        $niveau = new Niveau();
        $niveauForm = $this->createForm(NiveauType::class, $niveau)
            ->add('Ajouter', SubmitType::class, [
                'attr'=> [
                    'class'=>'btn'
                ]]);

        $niveauForm->handleRequest($request);

        if ($niveauForm->isSubmitted() && $niveauForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($niveau);
            $em->flush($niveau);

            return $this->redirectToRoute('app_admin_niveaux_index');
        }

        return $this->render('Admin/Niveaux/new.html.twig', [
            'niveauForm' => $niveauForm->createView()
        ]);
    }

    public function editAction(Request $request, Niveau $niveau){

        $niveauForm = $this->createForm(NiveauType::class, $niveau)
            ->add('Modifier', SubmitType::class,[
                'attr' => [
                    'class'=> 'btn',
                ]]);

        $niveauForm->handleRequest($request);

        if ($niveauForm->isSubmitted() && $niveauForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_niveaux_index');
        }

        return $this->render('Admin/Niveaux/edit.html.twig', [
            'niveauForm' => $niveauForm->createView()
        ]);
    }

    public function deleteAction(Niveau $niveau){

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($niveau);
            $em->flush();
        } catch (DBALException $e) {
            $this->addFlash('danger', 'Ce niveau est lié à un ou plusieurs cours');
        }

        return $this->redirectToRoute('app_admin_niveaux_index');
    }
}