<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Evenement
 */
class Evenement
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomEvenement;

    /**
     * @var string
     */
    private $lieuEvenement;

    /**
     * @var \DateTime
     */
    private $dateEvenement;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    private $imageLien;

    /**
     * @var ArrayCollection
     */
    private $cours;

    /**
     * Evenement constructor.
     */
    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->dateEvenement = new \DateTime();
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
     * Set nomEvenement
     *
     * @param string $nomEvenement
     *
     * @return Evenement
     */
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    /**
     * Get nomEvenement
     *
     * @return string
     */
    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    /**
     * Set lieuEvenement
     *
     * @param string $lieuEvenement
     *
     * @return Evenement
     */
    public function setLieuEvenement($lieuEvenement)
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    /**
     * Get lieuEvenement
     *
     * @return string
     */
    public function getLieuEvenement()
    {
        return $this->lieuEvenement;
    }

    /**
     * Set dateEvenement
     *
     * @param \DateTime $dateEvenement
     *
     * @return Evenement
     */
    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    /**
     * Get dateEvenement
     *
     * @return \DateTime
     */
    public function getDateEvenement()
    {
        return $this->dateEvenement;
    }

    /**
     * @return ArrayCollection
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * @param Cours
     *
     * @return Evenement
     */
    public function addCours(Cours $cours){

        if (!$this->cours->contains($cours)) {
            $this->cours->add($cours);
        }

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $image
     * @return Evenement
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageLien()
    {
        return $this->imageLien;
    }

    /**
     * @param string $imageLien
     * @return Evenement
     */
    public function setImageLien($imageLien)
    {
        $this->imageLien = $imageLien;
        return $this;
    }
}

