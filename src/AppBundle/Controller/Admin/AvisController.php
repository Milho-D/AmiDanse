<?php
/**
 * Created by PhpStorm.
 * User: allar
 * Date: 05/05/2017
 * Time: 14:20
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Cours;
use AppBundle\Form\AdminForm\AvisType;
use AppBundle\Form\AdminForm\CourantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AvisController extends Controller
{
    public function newAction(Request $request, Cours $cours)
    {
        $em = $this->getDoctrine()->getManager();
        $avis = new Avis();

        if(!$cours->getDanseurs()->contains($this->getUser()))
        {
            $this->addFlash('danger','Vous n\'avez pas participé à ce cours ');
            return $this->redirectToRoute('app_admin_cours_suivi');
        }
        if($em->getRepository('AppBundle:Avis')->findAvisByCoursAndDanseur($this->getUser(), $cours) !== null)
        {
            $this->addFlash('danger','Vous avez déja écrit un avis pour ce cours ');
            return $this->redirectToRoute('app_admin_cours_suivi');
        }

        $avisForm = $this->createForm(AvisType::class, $avis)
            ->add('Envoyer', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn'
                ]
            ]);

        $avisForm->handleRequest($request);

        if ($avisForm->isSubmitted() && $avisForm->isValid()) {
            $avis->setDanseur($this->getUser());
            $avis->setCours($cours);

            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush($avis);

            return $this->redirectToRoute('app_cours_show', ['id'=>$cours->getId()]);
        }

        return $this->render('Admin/Avis/new.html.twig',[
            'avisForm' => $avisForm->createView(),
            'cours'=>$cours
        ]);
    }

    public function editAction(Request $request, Avis $avis)
    {
        $avisForm = $this->createForm(AvisType::class, $avis)
            ->add('Modifier', SubmitType::class,[
                'attr' => [
                    'class'=> 'btn',
                ]]);
        $avisForm->handleRequest($request);

        if($avisForm->isValid() && $avisForm->isSubmitted())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_users_index');
        }

        return $this->render('Admin/Avis/edit.html.twig', [
            'avisForm' => $avisForm->createView()
        ]);
    }

    public function showAction()
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (!array_search("ROLE_RESPONSABLE", $currentUser->getRoles()) !== false) {
            $listeDAvis = $em->getRepository('AppBundle:Avis')->findByAnimateur($currentUser);
        }
        else{
            $listeDAvis = $em->getRepository('AppBundle:Avis')->findAll();

        }

        return $this->render('Admin/Avis/show.html.twig', [
            'listeDAvis' => $listeDAvis
        ]);
    }

    public function showDetailAction(Avis $avis)
    {
        $em = $this->getDoctrine()->getManager();

        $oneAvis = $em->getRepository('AppBundle:Avis')->findOneBy(['id'=> $avis->getId()]);

        return $this->render('Admin/Avis/showDetail.html.twig', [
            'avis' => $oneAvis
        ]);
    }

    public function showByCoursAction(Cours $cours)
    {
        $em = $this->getDoctrine()->getManager();

        $listeDAvis = $em->getRepository('AppBundle:Avis')->findBy(['cours'=>$cours]);

        return $this->render('Admin/Avis/showByCours.html.twig', [
            'listeDAvis' => $listeDAvis,
            'cours'=>$cours
        ]);
    }




}