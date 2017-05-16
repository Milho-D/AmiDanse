<?php

namespace AppBundle\Entity;

/**
 * Niveau
 */
class Niveau
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nomNiveau;


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
     * Set nomNiveau
     *
     * @param string $nomNiveau
     *
     * @return Niveau
     */
    public function setNomNiveau($nomNiveau)
    {
        $this->nomNiveau = $nomNiveau;

        return $this;
    }

    /**
     * Get nomNiveau
     *
     * @return string
     */
    public function getNomNiveau()
    {
        return $this->nomNiveau;
    }
}

