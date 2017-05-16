<?php

/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 25/04/2017
 * Time: 21:29
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserBundle\Form\DanseurRegistrationType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render(':Public:login.html.twig', array(
            'message'         => $error,
        ));
    }

    public function registerUserAction(Request $request){

        $user = new User();
        $form = $this->createForm(DanseurRegistrationType::class, $user)
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn',
                    'id' => 'inscription'
                ]
            ]);

        $form->handleRequest($request);

        $user->setEstResponsable(false);
        $user->setEstProfesseur(false);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $uploader = $this->get('app_upload_image');

            if ($user->getPicture()) {

                $filename = $uploader->upload($user->getPicture());

                $user->setPictureName($filename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_index');

        }

        return $this->render(
            ':Public:register.html.twig',
            array('registerForm' => $form->createView())
        );
    }
}