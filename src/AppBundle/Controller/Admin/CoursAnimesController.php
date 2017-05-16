<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 07/05/2017
 * Time: 22:19
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Cours;
use AppBundle\Form\AdminForm\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CoursAnimesController extends Controller
{
    public function indexAction(){

        $currentUser = $this->getUser();

        $coursvenir = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findByAnimateurVenir($currentUser);

        $courspasse = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findByAnimateurPasse($currentUser);

        return $this->render('Admin/CoursAnimes/index.html.twig',[
            'coursvenir'=>$coursvenir,
            'courspasse'=>$courspasse
        ]);
    }
}