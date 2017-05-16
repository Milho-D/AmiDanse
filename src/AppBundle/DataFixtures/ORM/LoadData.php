<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

/**
 * Created by PhpStorm.
 * User: fanfan
 * Date: 08/05/2017
 * Time: 17:27
 */
class LoadData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->directory = realpath(__DIR__ . '/../../Resources/fixtures');

        Fixtures::load([
            $this->directory.'/user.yml',
            $this->directory.'/courant.yml',
            $this->directory.'/type.yml',
            $this->directory.'/salle.yml',
            $this->directory.'/niveau.yml',
            $this->directory.'/evenement.yml',
            $this->directory.'/cours.yml',
            $this->directory.'/avis.yml',
        ], $manager, [
            'providers' => [$this]
        ]);

    }

    public function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder');

        return $encoder->encodePassword($user, $plainPassword);
    }
}