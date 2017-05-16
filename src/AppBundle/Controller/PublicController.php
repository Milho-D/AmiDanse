<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\PublicForm\ContactType;
use AppBundle\Form\PublicForm\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PublicController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Public/index.html.twig');
    }

    public function detailDansesAction(Request $request)
    {
        $courants = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Courant')
            ->findAll();

        $types = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Type')
            ->findAll();


        return $this->render('Public/danses.html.twig', [
            'courants'=>$courants,
            'types'=>$types

        ]);
    }

    public function ajaxDansesAction(Request $request){

        if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
            $id = $request->request->get('id');

            if ($id != null)
            {
                $courant = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Courant')
                    ->findOneBy(['id'=>$id]);

                $types = $this->getDoctrine()
                    ->getRepository('AppBundle:Type')
                    ->findByCourants($courant);

                if (!empty($types)){

                    foreach ($types as $type){
                        $jsonContent[] = [
                            'nomCourant' => $courant->getNomCourant(),
                            'nomType' => $type['nomType'],
                            'idType' => $type['id'],
                            'urlVideo' => $type['video']
                        ];
                    }

                } else {

                    $jsonContent[] = [
                        'nomCourant' => $courant->getNomCourant(),
                        'nomType' => 'pas de type',
                        'idType' => '0',
                        'urlVideo' => false
                    ];
                }

                return new JsonResponse($jsonContent);

            }
        }
        return new Response('Nonnn ....');
    }

    public function quiSommesNousAction(Request $request)
    {
        return $this->render('Public/quisommesnous.html.twig');
    }

    public function agendaAction()
    {
        $cours = $this->getDoctrine()
            ->getRepository('AppBundle:Cours')
            ->findAll();

        $evenements = $this->getDoctrine()
            ->getRepository('AppBundle:Evenement')
            ->findAll();

        if (!empty($cours)){

            foreach ($cours as $cour){

                $jsonCours[] = [
                    'title' => '('.$cour->getType()->getNomType().') '.$cour->getNomCours(),
                    'start' => $cour->getDateDebut()->format('Y-m-d H:i:s'),
                    'end' => $cour->getDateFin()->format('Y-m-d H:i:s'),
                    'url' => '/cours/'.$cour->getId(),
                    'color'=> '#225378'
                ];
            }

            $coursJson = json_encode($jsonCours);

        } else {
            $coursJson = json_encode('');
        }

        if (!empty($evenements)){

            foreach ($evenements as $evenement){

                $jsonEvents[] = [
                    'title' => $evenement->getNomEvenement(),
                    'start' => $evenement->getDateEvenement()->format('Y-m-d H:i:s'),
                    'url' => '/evenements/'.$evenement->getId(),
                    'color'=> '#EB7F00'
                ];
            }

            $eventsJson = json_encode($jsonEvents);

        } else {

            $eventsJson = json_encode('');
        }


        return $this->render('Public/agenda.html.twig',[
            'cours' => $coursJson,
            'evenements' => $eventsJson
        ]);
    }

    public function contactAction(Request $request)
    {
        $contactForm = $this
            ->createForm(ContactType::class)
            ->add('send', SubmitType::class,[
                'attr'=> [
                    'class'=>'btn',
                    'placeholder'=> 'Envoyer'
                ]
            ]);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $message = $contactForm->getData();

            $mailer = $this->get('app_mailer');
            $mailer->sendContactEmail($message);

            $this->addFlash('success', 'Votre message à bien été envoyé');

            return $this->redirect('/');
        }

        return $this->render('Public/contact.html.twig',[
            'contactForm'=> $contactForm->createView()
        ]);
    }

    public function mentionsLegalesAction()
    {
        return $this->render('Public/mentionslegales.html.twig');
    }

    public function planSiteAction()
    {
        return $this->render('Public/plandusite.html.twig');
    }
}
