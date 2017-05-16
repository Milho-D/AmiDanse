<?php

namespace AppBundle\Entity;

use UserBundle\Entity\User;

/**
 * Avis
 */
class Avis
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $noteAvis;

    /**
     * @var string
     */
    private $messageAvis;

    /**
     * @var Cours
     */
    private $cours;

    /**
     * @var User
     */
    private $danseur;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set noteAvis
     *
     * @param integer $noteAvis
     *
     * @return Avis
     */
    public function setNoteAvis($noteAvis)
    {
        $this->noteAvis = $noteAvis;

        return $this;
    }

    /**
     * Get noteAvis
     *
     * @return int
     */
    public function getNoteAvis()
    {
        return $this->noteAvis;
    }

    /**
     * Set messageAvis
     *
     * @param string $messageAvis
     *
     * @return Avis
     */
    public function setMessageAvis($messageAvis)
    {
        $this->messageAvis = $messageAvis;

        return $this;
    }

    /**
     * Get messageAvis
     *
     * @return string
     */
    public function getMessageAvis()
    {
        return $this->messageAvis;
    }

    /**
     * @return mixed
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * @param mixed $cours
     * @return Avis
     */
    public function setCours($cours)
    {
        $this->cours = $cours;
        return $this;
    }

    /**
     * @return User
     */
    public function getDanseur()
    {
        return $this->danseur;
    }


    /**
     * @param mixed $user
     * @return Avis
     */
    public function setDanseur(User $user)
    {
        $this->danseur = $user;
        return $this;
    }
}

