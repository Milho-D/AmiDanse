<?php
/**
 * Created by PhpStorm.
 * User: francois
 * Date: 02/04/2017
 * Time: 18:35
 */

namespace UserBundle\Entity;
use AppBundle\Entity\Cours;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

class User implements UserInterface, \Serializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $sexe;

    /**
     * @var int
     */
    private $salt;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @var boolean
     */
    private $estProfesseur;

    /**
     * @var boolean
     */
    private $etat;

    /**
     * @var boolean
     */
    private $statut;

    /**
     * @var boolean
     */
    private $estResponsable;

    /**
     * @var ArrayCollection
     */
    private $coursAnimes;

    /**
     * @var ArrayCollection
     */
    private $coursDanses;

    /**
     * @var UploadedFile
     */
    private $picture;

    /**
     * @var string
     */
    private $pictureName;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->setEtat(true);
        $this->addRole('ROLE_DANSEUR');
        $this->coursAnimes = new ArrayCollection();
        $this->coursDanses = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     * @return $this
     */
    public function setRoles($roles){
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param string $role
     */
    public function addRole($role){
        array_push($this->roles, $role);
    }

    /**
     * @return boolean
     */
    public function getEstProfesseur()
    {
        return $this->estProfesseur;
    }

    /**
     * @param boolean $estProfesseur
     * @return User
     */
    public function setEstProfesseur($estProfesseur)
    {
        if ($estProfesseur === true){
            $this->addRole('ROLE_PROFESSEUR');
        }
        $this->estProfesseur = $estProfesseur;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param boolean $etat
     * @return User
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param boolean $statut
     * @return User
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEstResponsable()
    {
        return $this->estResponsable;
    }

    /**
     * @param boolean $estReponsable
     * @return User
     */
    public function setEstResponsable($estResponsable)
    {
        if ($estResponsable === true){
            $this->addRole('ROLE_RESPONSABLE');
        }
        $this->estResponsable = $estResponsable;
        return $this;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @return ArrayCollection
     */
    public function getCoursAnimes()
    {
        return $this->coursAnimes;
    }

    /**
     * @return ArrayCollection
     */
    public function getCoursDanses()
    {
        return $this->coursDanses;
    }

    /**
     * @param Cours $coursAnime
     */
    public function addCoursAnimes(Cours $coursAnime){

        if (!$this->coursAnimes->contains($coursAnime)) {
            $this->coursAnimes->add($coursAnime);
        }
    }

    /**
     * @param Cours $coursDanse
     */
    public function addCoursDanses(Cours $coursDanse){

        if (!$this->coursDanses->contains($coursDanse)) {
            $this->coursDanses->add($coursDanse);
        }
    }

    /**
     * @return UploadedFile
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param UploadedFile $image
     */
    public function setPicture($image)
    {
        $this->picture = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * @param string $pictureName
     * @return User
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;
        return $this;
    }

}