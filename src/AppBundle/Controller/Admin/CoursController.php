<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdminForm\CoursType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\IsFalse;


class CoursController extends Controller
{
    public function indexAction()
    {
        $cours = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findBy([], ['id'=>'desc']);

        return $this->render('Admin/Cours/index.html.twig', [
            'cours'=> $cours,

        ]);
    }

    public function showAction(Cours $cours){

        return $this->render(':Public:cours.html.twig', array(
            'cours' => $cours
        ));


    }

    public function deleteAction(Cours $cours){

        $now = new \DateTime();

        if ($cours->getDateDebut()->getTimestamp() > $now->getTimestamp()){

            $em = $this->getDoctrine()->getManager();
            $em->remove($cours);
            $em->flush();

        } else {
            $this->addFlash('danger','Le cours est déja passé');
        }

        return $this->redirectToRoute('app_admin_cours_index');
    }

    public function newAction(Request $request)
    {

        $cours = new Cours();
        $coursForm = $this->createForm(CoursType::class, $cours)
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn'
                ]]);

        $coursForm->handleRequest($request);

        if ($coursForm->isSubmitted() && $coursForm->isValid()) {

            $dateDebut = $cours->getDateDebut()->format('Y-m-d H:i:s');

            $dateFin = new \DateTime($dateDebut);

            $duree = $coursForm->get('duree')->getData();

            $dateFin->modify('+'.$duree.' minutes');

            $cours->setDateFin($dateFin);

            $coursSalle = $this->getDoctrine()
                ->getRepository('AppBundle:Cours')
                ->findBySalleAndDateDebut($cours->getSalle(),$cours->getDateDebut()->format('Y-m-d'));

            foreach ($coursSalle as $cSalle){
                for ($i = $cours->getDateDebut()->getTimestamp(); $i <= $cours->getDateFin()->getTimestamp(); $i++) {
                    if ($i > $cSalle->getDateDebut()->getTimeStamp() AND $i < $cSalle->getDateFin()->getTimeStamp()){
                        $prise = true;
                        break;
                    }
                }
            }

            dump(isset($prise));
            if (isset($prise)){
                $this->addFlash('danger', 'La salle '.$cours->getSalle()->getNomSalle().' est déja prise sur ce créneau');

            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cours);
                $em->flush($cours);

                return $this->redirectToRoute('app_admin_cours_index');
            }

        }

        return $this->render('Admin/Cours/new.html.twig', [
            'coursForm' => $coursForm->createView()
        ]);
    }

    public function editAction(Request $request, Cours $cours){

        $coursForm = $this->createForm(CoursType::class, $cours)
            ->add('Modifier', SubmitType::class,  [
                'attr' => [
                    'class' => 'btn'
                ]]);

        $coursForm->handleRequest($request);

        if ($coursForm->isSubmitted() && $coursForm->isValid()) {

            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('app_admin_cours_index');
        }

        return $this->render('Admin/Cours/edit.html.twig', [
            'coursForm' => $coursForm->createView()
        ]);
    }
}