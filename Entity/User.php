<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\MappedSuperclass
 */
class User extends BaseUser {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;

    /**
     *
     * @var string @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;

    /**
     *
     * @var \DateTime @ORM\Column(name="naissance_at", type="datetime", nullable=true)
     */
    protected $naissanceAt;

    /**
     *
     * @var string @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    protected $sexe;

    /**
     *
     * @var \DateTime @ORM\Column(name="inscription_at", type="datetime")
     */
    protected $inscriptionAt;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom            
     * @return User
     */
    public function setNom($nom) {
        $this->nom = $nom;
        
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom            
     * @return User
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set naissanceAt
     *
     * @param \DateTime $naissanceAt            
     * @return User
     */
    public function setNaissanceAt($naissanceAt) {
        $this->naissanceAt = $naissanceAt;
        
        return $this;
    }

    /**
     * Get naissanceAt
     *
     * @return \DateTime
     */
    public function getNaissanceAt() {
        return $this->naissanceAt;
    }

    /**
     * Set sexe
     *
     * @param string $sexe            
     * @return User
     */
    public function setSexe($sexe) {
        $this->sexe = $sexe;
        
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe() {
        return $this->sexe;
    }

    /**
     * Set inscriptionAt
     *
     * @param \DateTime $inscriptionAt            
     * @return User
     */
    public function setInscriptionAt($inscriptionAt) {
        $this->inscriptionAt = $inscriptionAt;
        
        return $this;
    }

    /**
     * Get inscriptionAt
     *
     * @return \DateTime
     */
    public function getInscriptionAt() {
        return $this->inscriptionAt;
    }
}