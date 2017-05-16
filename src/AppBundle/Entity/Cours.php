<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\User;

/**
 * Cours
 */
class Cours
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomCours;

    /**
     * @var \DateTime
     */
    private $dateDebut;

    /**
     * @var \DateTime
     */
    private $dateFin;

    /**
     * @var Niveau
     */
    private $niveau;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var Salle
     */
    private $salle;

    /**
     * @var ArrayCollection
     */
    private $evenements;

    /**
     * @var ArrayCollection
     */
    private $danseurs;

    /**
     * @var ArrayCollection
     */
    private $animateurs;

    /**
     * @var int
     */
    private $placesRestantes;

    /**
     * Cours constructor.
     */
    public function __construct()
    {
        $this->danseurs = new ArrayCollection();
        $this->animateurs = new ArrayCollection();
        $this->dateDebut = new \DateTime();
        $this->dateFin = new \DateTime();
        $this->evenements = new ArrayCollection();
    }


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
     * Set nomCours
     *
     * @param string $nomCours
     *
     * @return Cours
     */
    public function setNomCours($nomCours)
    {
        $this->nomCours = $nomCours;

        return $this;
    }

    /**
     * Get nomCours
     *
     * @return string
     */
    public function getNomCours()
    {
        return $this->nomCours;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Cours
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Cours
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @return Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param Niveau $niveau
     * @return Cours
     */
    public function setNiveau(Niveau $niveau)
    {
        $this->niveau = $niveau;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Cours
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @return Salle
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * @param Salle $salle
     * @return Cours
     */
    public function setSalle(Salle $salle)
    {
        $this->salle = $salle;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param Evenement $evenement
     * @return $this
     */
    public function addEvenement(Evenement $evenement)
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDanseurs()
    {
        return $this->danseurs;
    }

    /**
     * @param User $user
     */
    public function addDanseur(User $user)
    {

        if (!$this->danseurs->contains($user)) {
            $this->danseurs->add($user);
        }
    }

    /**
     * @param User $user
     */
    public function removeDanseur(User $user)
    {

        if ($this->danseurs->contains($user)) {
            $this->danseurs->removeElement($user);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getAnimateurs()
    {
        return $this->animateurs;
    }

    /**
     * @param User $user
     */
    public function addAnimateur(User $user)
    {
        if (!$this->animateurs->contains($user)) {
            $this->animateurs->add($user);
        }
    }

    /**
     * @return int
     */
    public function getPlacesRestantes(){

        return $this->placesRestantes = $this->salle->getCapaciteSalle() - count($this->getDanseurs());

    }
}


