<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageType
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\User", inversedBy="comments")
     */
    private $author;
    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\Book", inversedBy="comments")
     */
    private $article;

    public function __construct()
    {
        $this->dateAdded=new \DateTime('now');
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
     * Set description
     *
     * @param string $description
     *
     * @return Comment
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
     * @return Comment
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
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Comment
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Book
     */
    public function getArticle(): Book
    {
        return $this->article;
    }

    /**
     * @param Book $article
     * @return Comment
     */
    public function setArticle(Book $article)
    {
        $this->article = $article;
        return $this;
    }
}

