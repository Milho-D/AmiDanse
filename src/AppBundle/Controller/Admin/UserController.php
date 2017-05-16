<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 19:06
 */

namespace AppBundle\Controller\Admin;

use Doctrine\DBAL\DBALException;
use UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\AdminUserType;
use UserBundle\Form\ChangePasswordType;
use UserBundle\Form\DanseurRegistrationType;

class UserController extends Controller
{
    public function indexAction(){

        $users = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findAll();

        return $this->render(':Admin/Users:index.html.twig',[
            'users' => $users
        ]);

    }

    public function newAction(Request $request){

        $user = new User();
        $userForm = $this->createForm(AdminUserType::class, $user)
            ->add('Ajouter', SubmitType::class, [
                'attr'=> [
                    'class'=>'btn'
                ]]);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

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
            $em->flush($user);

            return $this->redirectToRoute('app_admin_users_index');
        }

        return $this->render(':Admin/Users:edit.html.twig',[
            'userForm' => $userForm->createView()
        ]);

    }

    public function editAction(User $user, Request $request){

        $userForm = $this->createForm(AdminUserType::class, $user)
            ->remove('plainPassword')
            ->add('Modifier', SubmitType::class, [
                'attr' => [
                    'class'=> 'btn',
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

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_users_index');
        }

        return $this->render(':Admin/Users:edit.html.twig',[
            'userForm' => $userForm->createView()
        ]);
    }

    public function editPasswordAction(User $user, Request $request){

        $userForm = $this->createForm(ChangePasswordType::class, $user)
            ->add('Modifier', SubmitType::class,[
                'attr' => [
                    'class'=> 'btn',
                ]]);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_users_index');
        }

        return $this->render(':Admin/Users:editpassword.html.twig',[
            'userForm' => $userForm->createView()
        ]);
    }
}