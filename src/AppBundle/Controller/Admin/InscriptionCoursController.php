<?php
/**
 * Created by PhpStorm.
 * User: allar
 * Date: 28/04/2017
 * Time: 10:03
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Cours;
use AppBundle\Entity\Type;
use AppBundle\Form\AdminForm\InscriptionCoursOneType;
use AppBundle\Form\AdminForm\InscriptionCoursTwoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class InscriptionCoursController extends Controller
{
    public function indexAction(Request $request)
    {
        $typeForm = $this->createForm(InscriptionCoursOneType::class)
            ->add('rechercher cours', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn'
                ]
            ]);

        $typeForm->handleRequest($request);

        if ($typeForm->isSubmitted() && $typeForm->isValid()) {

            return $this->redirectToRoute('app_admin_cours_inscription', [

                'id' => $typeForm->get('type')->getData()->getId(),

            ]);

        }

        return $this->render('Admin/CoursSuivi/inscriptionType.html.twig', [
            'typeForm'=>$typeForm->createView()
        ]);
    }

    public function listCoursAction(Type $type, Request $request){

        $now = new \DateTime();
        $datetime = $now->format('Y-m-d H:i:s');

        $currentUser = $this->getUser();

        $cours = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findByType($type, $currentUser, $datetime);

        if (count($cours) === 0){

            $this->addFlash('danger','pas de cours disponible pour ce type');
            return $this->redirectToRoute('app_admin_cours_choixtype');

        }

        $inscriptionForm = $this->createForm(InscriptionCoursTwoType::class, ['type' => $type , 'user' => $currentUser])
            ->add('s\'inscrire', SubmitType::class, [
                'attr' => [
                    'class'=>'btn'
                ]
            ]);

        $inscriptionForm->handleRequest($request);

        if ($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()) {

            $cours = $inscriptionForm->getData()['cours'];

            if ($cours){
                $this->inscriptionAction($cours);

                return $this->redirectToRoute('app_admin_cours_suivi');
            }

        }

        return $this->render('Admin/CoursSuivi/inscriptionForm.html.twig', [
            'inscriptionForm'=>$inscriptionForm->createView()
        ]);
    }

    public function inscriptionAction(Cours $cours){

        if ($cours->getPlacesRestantes() !== 0){

            $cours->addDanseur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Inscription confirmée.');

        } else {

            $this->addFlash('danger', 'Plus de place pour le cours: '.$cours->getNomCours());

        }

        return $this->redirectToRoute('app_admin_cours_suivi');
    }

    public function desinscriptionAction(Cours $cours){

        $cours->removeDanseur($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($cours);
        $em->flush();

        $this->addFlash('success', 'vous avez bien été désinscrit');

        return $this->redirectToRoute('app_admin_cours_suivi');
    }

}