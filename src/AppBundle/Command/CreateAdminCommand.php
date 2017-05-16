<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use UserBundle\Entity\User;

/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 10/05/2017
 * Time: 16:02
 */
class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:createresponsable')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new responsable user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $responsable = new User();

        $helper = $this->getHelper('question');

        $Question = new Question('nom: ');
        $nom = $helper->ask($input, $output, $Question);
        $responsable->setNom($nom);

        $Question = new Question('prenom: ');
        $prenom = $helper->ask($input, $output, $Question);
        $responsable->setPrenom($prenom);

        $Question = new Question('email: ');
        $email = $helper->ask($input, $output, $Question);
        $responsable->setEmail($email);

        $Question = new Question('nom d\'utilisateur: ');
        $username = $helper->ask($input, $output, $Question);
        $responsable->setUsername($username);

        $Question = new Question('password: ');
        $Question->setHidden(true);
        $password = $helper->ask($input, $output, $Question);
        $encoder = $this->getContainer()->get('security.password_encoder')
            ->encodePassword($responsable, $password);
        $responsable->setPassword($encoder);

        $responsable->setEtat(true)
            ->setEstProfesseur(false)
            ->setEstResponsable(true)
            ->setSexe('Homme');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($responsable);
        $em->flush();

        $output->writeln([
            'la responsable a bien été créer'
        ]);
    }

}