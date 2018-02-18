<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Table(name="`audio`", indexes={
 *   @ORM\Index(name="hash_idx", columns={"hash"})
 * })
 */
class Audio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`hash`", type="string", length=40, options={"default": "abc"})
     */
    protected $hash;

    /**
     * @ORM\Column(name="`name`", type="string", length=128)
     */
    protected $name;

    /**
     * @ORM\Column(name="`length`", type="smallint", options={"default": 123, "unsigned": true})
     */
    protected $length;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="audios")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="Playlist", mappedBy="audios")
     */
    protected $playlists;

    /**
     * @ORM\Column(name="`size`", type="integer")
     */
    protected $size;

    /**
     * @ORM\Column(name="`mime_type`", type="string", length=64)
     */
    protected $mimeType;

    /**
     * @ORM\Column(name="`original_name`", type="string", length=128, nullable=false)
     */
    protected $originalName;

    /**
     * @Vich\UploadableField(mapping="audio_file", fileNameProperty="name", size="size", mimeType="mimeType", originalName="originalName")
     * @var File
     */
    protected $audioFile;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="`updated_at`", type="datetime")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set audioFile
     *
     * @param File $audioFile
     *
     * @return Audio
     */
    public function setImageFile(File $audioFile = null)
    {
        $this->audioFile = $audioFile;

        $this->hash = new \DateTime('now');
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
     * Set hash
     *
     * @param string $hash
     *
     * @return Audio
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Audio
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
     * Set originalName
     *
     * @param string $originalName
     *
     * @return Audio
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set length
     *
     * @param integer $length
     *
     * @return Audio
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Audio
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

    /**
     * Set audioFile
     *
     * @param File $audioFile
     *
     * @return Audio
     */
    public function setAudioFile(File $audioFile = null)
    {
        $this->audioFile = $audioFile;

        return $this;
    }

    /**
     * Get audioFile
     *
     * @return File
     */
    public function getAudioFile()
    {
        return $this->audioFile;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Audio
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Audio
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Audio
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Audio
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add playlist
     *
     * @param \AppBundle\Entity\Playlist $playlist
     *
     * @return Audio
     */
    public function addPlaylist(\AppBundle\Entity\Playlist $playlist)
    {
        $this->playlists[] = $playlist;

        $playlist->addAudio($this);

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
        $playlist->removeAudio($this);
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
