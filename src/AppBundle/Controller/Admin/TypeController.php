<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 24/04/2017
 * Time: 22:55
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Type;
use AppBundle\Form\AdminForm\TypedanseType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TypeController extends Controller
{
    public function newAction(Request $request)
    {

        $type = new Type();
        $typeForm = $this->createForm(TypedanseType::class, $type)
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn'
                ]
            ]);

        $typeForm->handleRequest($request);

        if ($typeForm->isSubmitted() && $typeForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush($type);

            return $this->redirectToRoute('app_admin_danses_index');
        }

        return $this->render('Admin/Types/new.html.twig', [
            'typeForm' => $typeForm->createView()
        ]);
    }

    public function editAction(Request $request, Type $type)
    {

        $typeForm = $this->createForm(TypedanseType::class, $type)
            ->add('Modifier', SubmitType::class, [
                'attr' => [
                    'class' => 'btn',
                ]]);

        $typeForm->handleRequest($request);

        if ($typeForm->isSubmitted() && $typeForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_danses_index');
        }

        return $this->render('Admin/Types/edit.html.twig', [
            'typeForm' => $typeForm->createView()
        ]);
    }

    public function deleteAction(Type $type)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($type);
            $em->flush();

        } catch (DBALException $e) {

            $this->addFlash('danger', 'Ce type est lié à un ou plusieurs cours');

        }

        return $this->redirectToRoute('app_admin_danses_index');
    }
}