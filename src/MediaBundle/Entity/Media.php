<?php

namespace MediaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="dio_media")
 * @ORM\Entity(repositoryClass="MediaRepository")
 * @Gedmo\Uploadable
 */
class Media
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var MediaCategory
     *
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\MediaCategory", inversedBy="medias")
     * @ORM\JoinColumn(name="mediacategory_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\User", inversedBy="medias")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)     *
     */
    private $owner;

    /**
     * @var MediaType
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\MediaType", inversedBy="medias")
     * @ORM\JoinColumn(name="mediatype_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128, nullable=false, name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="comment")
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="path")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="creation_date")
     * @Gedmo\Timestampable(on="create")
     */
    private $creationDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="update_date")
     * @Gedmo\Timestampable(on="update")
     */
    private $updateDate;

    /**
     * @var MediaKeyword[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MediaBundle\Entity\MediaKeyword", mappedBy="medias", cascade={"remove"})
     */
    private $keywords;

    /**
     * @ORM\Column(type="integer", nullable=true, name="mark")
     */
    private $mark = 0;

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
     * Get type.
     * @return MediaType The type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get category.
     * @return MediaType The category.
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get name.
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get comment.
     * @return string The comment.
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Get path.
     * @return string The path.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get owner.
     * @return User The owner.
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set category.
     */
    public function setCategory(MediaCategory $category)
    {
        // TODO : change file path upon category change
        $this->category = $category;
    }

    /**
     * Set type.
     */
    public function setType(MediaType $type)
    {
        $this->type = $type;
    }

    /**
     * Set name.
     * @param string $name The name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set comment.
     * @param string $comment The comment.
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Set path.
     * @param string $path The path.
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Set owner.
     * @param User $owner The owner.
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Set creationDate
     *
     * @param  \DateTime $creationDate
     * @return Media
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param  \DateTime $updateDate
     * @return Media
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->keywords = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add keyword
     *
     * @param  MediaKeyword $keyword
     * @return Media
     */
    public function addKeyword(MediaKeyword $keyword)
    {
        $this->keywords[] = $keyword;

        return $this;
    }

    /**
     * Remove keywords
     *
     * @param MediaKeyword $keyword
     */
    public function removeKeyword(MediaKeywords $keyword)
    {
        $this->keywords->removeElement($keyword);
    }

    /**
     * Get keywords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Increment mark
     *
     * @return Media
     */
    public function incrementMark()
    {
        ++$this->mark;

        return $this;
    }
    /**
     * Decrement mark
     *
     * @return Media
     */
    public function decrementMark()
    {
        --$this->mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Get webpath.
     * @return string The web accessible URL.
     */
    public function getWebPath()
    {
        return 'uploads/dio/'.$this->path;
    }

    public function __toString()
    {
        return $this->name." (".$this->getType()->getName().") - ".$this->getCategory()->getName();
    }

    private $file;

    public function setFile(\Symfony\Component\HttpFoundation\File\File $file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }
}
