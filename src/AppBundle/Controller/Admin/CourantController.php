<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 22:55
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Courant;
use AppBundle\Form\AdminForm\CourantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CourantController extends Controller
{
    public function indexAction(){

        $courants = $this->getDoctrine()
            ->getRepository('AppBundle:Courant')
            ->findAll();

        $types = $this->getDoctrine()
            ->getRepository('AppBundle:Type')
            ->findAll();

        return $this->render('Admin/Courants/index.html.twig',[
            'courants'=>$courants,
            'types'=>$types
        ]);
    }

    public function newAction(Request $request){

        $courant = new Courant();
        $courantForm = $this->createForm(CourantType::class, $courant)
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn'
                ]
            ]);

        $courantForm->handleRequest($request);

        if ($courantForm->isSubmitted() && $courantForm->isValid()) {

            $uploader = $this->get('app_upload_image');

            if ($courant->getImage()){

                $filename = $uploader->upload($courant->getImage());

                $courant->setImageName($filename);

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($courant);
            $em->flush($courant);

            return $this->redirectToRoute('app_admin_danses_index');
        }

        return $this->render('Admin/Courants/new.html.twig', [
            'courantForm' => $courantForm->createView()
        ]);
    }

    public function editAction(Request $request, Courant $courant){

        $courantForm = $this->createForm(CourantType::class, $courant)
            ->add('Modifier', SubmitType::class,[
            'attr' => [
            'class'=> 'btn',
                ]]);

        $courantForm->handleRequest($request);

        if ($courantForm->isSubmitted() && $courantForm->isValid()) {

            $uploader = $this->get('app_upload_image');

            if ($courant->getImage()){

                if ($courant->getImageName()){
                    $previousFile = $uploader->loadFile($courant->getImageName());

                    $uploader->remove($previousFile);
                }

                $filename = $uploader->upload($courant->getImage());

                $courant->setImageName($filename);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_danses_index');
        }

        return $this->render('Admin/Courants/edit.html.twig', [
            'courantForm' => $courantForm->createView()
        ]);
    }

    public function deleteAction(Courant $courant){

        if ($courant->getImageName()){
            $uploader = $this->get('app_upload_image');

            $file = $uploader->loadFile($courant->getImageName());

            $uploader->remove($file);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($courant);
        $em->flush();

        return $this->redirectToRoute('app_admin_danses_index');
    }
}