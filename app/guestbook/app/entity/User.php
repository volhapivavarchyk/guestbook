<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="users")
 */
class User
{
    /** @Id @Column(name="user_id", type="integer") @GeneratedValue**/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $email;
    /**
     * @OneToMany(targetEntity="Message", mappedBy="user")
     */
    protected $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }
    /**
     * $id getter
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * $name getter
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * $name setter
     * @return
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * $email getter
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * $email setter
     * @return
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    /**
     * @return Collection|Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
    /**
     * @return Collection|Message[]
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }
}
