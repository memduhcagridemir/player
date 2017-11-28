<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
     * @ORM\Column(name="`hash`", type="string", length=40, nullable=false)
     */
    protected $hash;

    /**
     * @ORM\Column(name="`name`", type="string", length=128, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(name="`original_name`", type="string", length=128, nullable=false)
     */
    protected $originalName;

    /**
     * @ORM\Column(name="`length`", type="smallint", nullable=false, options={"unsigned": true})
     */
    protected $length;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="audioFiles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @Vich\UploadableField(mapping="audio_file", fileNameProperty="name", size="size", mimeType="mimeType", originalName="originalName")
     * @var File
     */
    protected $audioFile;

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
}
