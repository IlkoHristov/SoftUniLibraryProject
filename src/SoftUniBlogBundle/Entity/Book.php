<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;
    /**
     * @var string
     */
    private $summary;

    /**
     * @var int
     *
     * @ORM\Column(name="authorId", type="integer")
     */

    private $authorId;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="authorId", referencedColumnName="id")
     */


    private $author;

    /**
     * @ORM\Column(name="view_count", type="integer")
     */
    private $viewCount;

    /**
     * @ORM\Column(name="image", type="text")
     */
    private $image;
    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private $comments;
    public function __construct()
    {
        $this->dateAdded=new \DateTime('now');
        $this->comments=new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Book
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        if($this->summary===null){
            $this->getSummary();
        }
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = substr($this->getDescription(), 0, strlen($this->
            getDescription())/2). "...";
    }

    /**
     * @return int
     *
     * @return User
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     *
     * @return Book
     */
    public function setAuthorId(int $authorId)
    {
        $this->authorId = $authorId;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return Book
     */
    public function setAuthor(User $author=null)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     */
    public function setComments(ArrayCollection $comments): void
    {
        $this->comments = $comments;
    }


}

