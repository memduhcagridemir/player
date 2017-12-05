<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`playlist`")
 */
class Playlist
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="playlists")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="Audio", inversedBy="playlists")
     */
    protected $audios;

    /**
     * @ORM\Column(name="`name`", type="string", length=256, nullable=false)
     */
    protected $name;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->audios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Playlist
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
     * Add audio
     *
     * @param \AppBundle\Entity\Audio $audio
     *
     * @return Playlist
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Playlist
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
