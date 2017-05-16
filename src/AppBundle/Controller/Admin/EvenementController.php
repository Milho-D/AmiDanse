<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 05/05/2017
 * Time: 08:51
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Evenement;
use AppBundle\Form\AdminForm\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){

        $evenements = $this->getDoctrine()
            ->getRepository('AppBundle:Evenement')
            ->findBy([],['id'=>'desc']);

        return $this->render('Admin/Evenements/index.html.twig',[
            'evenements'=>$evenements
        ]);
    }

    public function showAction(Evenement $evenement){

        return $this->render(':Public:evenement.html.twig',[
            'evenement'=>$evenement
        ]);
    }

    public function newAction(Request $request){

        $evenement = new Evenement();
        $evenementForm = $this->createForm(EvenementType::class, $evenement)
            ->add('Ajouter', SubmitType::class, [
                'attr'=> [
                    'class'=>'btn'
                ]]);

        $evenementForm->handleRequest($request);

        if ($evenementForm->isSubmitted() && $evenementForm->isValid()) {

            $uploader = $this->get('app_upload_image');

            if ($evenement->getImage()){

                $filename = $uploader->upload($evenement->getImage());

                $evenement->setImageLien($filename);

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush($evenement);

            return $this->redirectToRoute('app_admin_evenements_index');
        }

        return $this->render('Admin/Evenements/new.html.twig', [
            'evenementForm' => $evenementForm->createView()
        ]);
    }

    public function editAction(Request $request, Evenement $evenement){

        $evenementForm = $this->createForm(EvenementType::class, $evenement)
            ->add('Modifier', SubmitType::class,[
                'attr' => [
                    'class'=> 'btn',
                ]]);

        $evenementForm->handleRequest($request);
        dump($evenementForm);

        if ($evenementForm->isSubmitted() && $evenementForm->isValid()) {

            $uploader = $this->get('app_upload_image');

            if ($evenement->getImage()){

                if ($evenement->getImageLien()){

                    $previousFile = $uploader->loadFile($evenement->getImageLien());
                    $uploader->remove($previousFile);
                }

                $filename = $uploader->upload($evenement->getImage());

                $evenement->setImageLien($filename);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_evenements_index');
        }

        return $this->render('Admin/Evenements/edit.html.twig', [
            'evenementForm' => $evenementForm->createView()
        ]);
    }

    public function deleteAction(Evenement $evenement){

        if ($evenement->getImageLien()){
            $uploader = $this->get('app_upload_image');

            $file = $uploader->loadFile($evenement->getImageLien());

            $uploader->remove($file);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('app_admin_evenements_index');
    }
}