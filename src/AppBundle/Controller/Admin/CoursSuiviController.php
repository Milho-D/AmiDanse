<?php
/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 07/05/2017
 * Time: 22:18
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class CoursSuiviController extends Controller
{
    public function indexAction(){

        $currentUser = $this->getUser();

        $coursvenir = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findByDanseursVenir($currentUser);

        $courspasse = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findByDanseursPasse($currentUser);

        return $this->render('Admin/CoursSuivi/index.html.twig',[
            'coursvenir'=>$coursvenir,
            'courspasse'=>$courspasse
        ]);
    }
}