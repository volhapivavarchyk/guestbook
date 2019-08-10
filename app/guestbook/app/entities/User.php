<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @Table(name="users", indexes={@Index(name="search_idx", columns={"email"})})
 */
class User
{
    /** @Id @Column(name="user_id", type="integer", unique=true, nullable=true) @GeneratedValue**/
    protected $id;
    /** @Column(length=128) **/
    protected $name;
    /** @Column(length=128) **/
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
    public function getName(): ?string
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
    public function getEmail(): ?string
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
    public function getMessages(): Collection
    {
        return $this->messages;
    }
    /**
     * @return Collection|Message[]
     */
    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            //$message->setUser($this);
            $this->messages[] = $message;
        }
        return $this;
    }
    public function removeMessage(Message $message): self
    {
        $this->messages->removeElement($message);
    }
}
