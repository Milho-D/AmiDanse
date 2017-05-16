<?php

namespace AppBundle\Entity;

/**
 * Salle
 */
class Salle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomSalle;

    /**
     * @var int
     */
    private $numeroSalle;

    /**
     * @var int
     */
    private $capaciteSalle;


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
     * Set nomSalle
     *
     * @param string $nomSalle
     *
     * @return Salle
     */
    public function setNomSalle($nomSalle)
    {
        $this->nomSalle = $nomSalle;

        return $this;
    }

    /**
     * Get nomSalle
     *
     * @return string
     */
    public function getNomSalle()
    {
        return $this->nomSalle;
    }

    /**
     * Set numeroSalle
     *
     * @param integer $numeroSalle
     *
     * @return Salle
     */
    public function setNumeroSalle($numeroSalle)
    {
        $this->numeroSalle = $numeroSalle;

        return $this;
    }

    /**
     * Get numeroSalle
     *
     * @return int
     */
    public function getNumeroSalle()
    {
        return $this->numeroSalle;
    }

    /**
     * Set capaciteSalle
     *
     * @param integer $capaciteSalle
     *
     * @return Salle
     */
    public function setCapaciteSalle($capaciteSalle)
    {
        $this->capaciteSalle = $capaciteSalle;

        return $this;
    }

    /**
     * Get capaciteSalle
     *
     * @return int
     */
    public function getCapaciteSalle()
    {
        return $this->capaciteSalle;
    }
}

