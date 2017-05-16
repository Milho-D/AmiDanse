<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 17/04/2017
 * Time: 13:18
 */

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserBundle\Form\ChangePasswordType;
use UserBundle\Form\DanseurRegistrationType;
use UserBundle\Form\UserType;

class DashboardController extends Controller
{
    public function profilAction(){
        return $this->render('Admin/profil.html.twig');
    }

    public function editAction(Request $request){

        $user = $this->getUser();

        $userForm = $this->createForm(DanseurRegistrationType::class, $user)
            ->remove('plainPassword')
            ->add('Modifier', SubmitType::class,  [
                'attr' => [
                    'class' => 'btn'
            ]]);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $uploader = $this->get('app_upload_image');

            if ($user->getPicture()) {

                if ($user->getPictureName()){
                    $previousFile = $uploader->loadFile($user->getPictureName());

                    $uploader->remove($previousFile);
                }

                $filename = $uploader->upload($user->getPicture());

                $user->setPictureName($filename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('app_admin_profil');
        }

        return $this->render('Admin/modify_profil.html.twig',[
            'userForm'=> $userForm->createView()
        ]);

    }

    public function passwordChangeAction(Request $request){

        $user = $this->getUser();

        $passwordForm = $this->createForm(ChangePasswordType::class, $user)
            ->add('Modifier', SubmitType::class,   [
                'attr' => [
                    'class' => 'btn'
                ]]);

        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('app_admin_profil');
        }

        return $this->render('Admin/password.html.twig',[
            'passwordForm'=> $passwordForm->createView()
        ]);
    }
}