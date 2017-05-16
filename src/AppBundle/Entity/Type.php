<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\User;

/**
 * Type
 */
class Type
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomType;

    /**
     * @var ArrayCollection
     */
    private $courants;

    /**
     * @var User
     */
    private $referent;

    /**
     * @var string
     */
    private $video;

    /**
     * Type constructor.
     */
    public function __construct()
    {
        $this->courants = new ArrayCollection();
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
     * Set nomType
     *
     * @param string $nomType
     *
     * @return Type
     */
    public function setNomType($nomType)
    {
        $this->nomType = $nomType;

        return $this;
    }

    /**
     * @return string
     */
    public function getNomType()
    {
        return $this->nomType;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourants()
    {
        return $this->courants;
    }

    /**
     * @param Courant $courant
     */
    public function addCourant(Courant $courant){

        if (!$this->courants->contains($courant)) {
            $this->courants->add($courant);
        }
    }

    /**
     * @return User
     */
    public function getReferent()
    {
        return $this->referent;
    }

    /**
     * @param User $referent
     * @return Type
     */
    public function setReferent(User $referent)
    {
        $this->referent = $referent;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     * @return Type
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

}

