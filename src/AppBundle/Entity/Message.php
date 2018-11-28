<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MyEntity
 *
 * @ORM\Table(name="blog_message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="message_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="BlogUser", inversedBy="messages")
     * @ORM\JoinColumn(name="blog_user_id", referencedColumnName="blog_user_id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="datestamp", type="datetime")
     */
    private $dateStamp;

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
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return BlogUser
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param BlogUser $author
     * @return Message
     */
    public function setAuthor(BlogUser $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateStamp()
    {
        return $this->dateStamp;
    }

    /**
     * @param string $dateStamp
     * @return Message
     */
    public function setDateStamp($dateStamp)
    {
        $this->dateStamp = $dateStamp;

        return $this;
    }
}