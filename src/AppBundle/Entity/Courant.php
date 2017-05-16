<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Courant
 */
class Courant
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomCourant;

    /**
     * @var ArrayCollection
     */
    private $types;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    private $imageName;

    /**
     * Courant constructor.
     */
    public function __construct()
    {
        $this->types = new ArrayCollection();
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
     * Set nomCourant
     *
     * @param string $nomCourant
     *
     * @return Courant
     */
    public function setNomCourant($nomCourant)
    {
        $this->nomCourant = $nomCourant;

        return $this;
    }

    /**
     * Get nomCourant
     *
     * @return string
     */
    public function getNomCourant()
    {
        return $this->nomCourant;
    }

    /**
     * @return ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param Type $type
     */
    public function addType(Type $type){

        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }
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
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     * @return Courant
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

}

