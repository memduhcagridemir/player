<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=false, options={"default": "User Name"})
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true, options={"default": null})
     */
    protected $bio;

    /**
     * @ORM\OneToMany(targetEntity="Audio", mappedBy="user")
     */
    protected $audios;

    /**
     * @ORM\OneToMany(targetEntity="Playlist", mappedBy="user")
     */
    protected $playlists;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->setUsername($email);
        parent::setEmail($email);

        return $this;
    }

    /**
     * Set email canonical.
     *
     * @param string $emailCanonical
     *
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->setUsernameCanonical($emailCanonical);
        parent::setEmailCanonical($emailCanonical);

        return $this;
    }

    /**
     * Add audio
     *
     * @param \AppBundle\Entity\Audio $audio
     *
     * @return User
     */
    public function addAudio(\AppBundle\Entity\Audio $audio)
    {
        $this->audios[] = $audio;

        return $this;
    }

    /**
     * Remove audio
     *
     * @param \AppBundle\Entity\Audio $audio
     */
    public function removeAudio(\AppBundle\Entity\Audio $audio)
    {
        $this->audios->removeElement($audio);
    }

    /**
     * Get audios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAudios()
    {
        return $this->audios;
    }

    /**
     * Add playlist
     *
     * @param \AppBundle\Entity\Playlist $playlist
     *
     * @return User
     */
    public function addPlaylist(\AppBundle\Entity\Playlist $playlist)
    {
        $this->playlists[] = $playlist;

        return $this;
    }

    /**
     * Remove playlist
     *
     * @param \AppBundle\Entity\Playlist $playlist
     */
    public function removePlaylist(\AppBundle\Entity\Playlist $playlist)
    {
        $this->playlists->removeElement($playlist);
    }

    /**
     * Get playlists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }
}
