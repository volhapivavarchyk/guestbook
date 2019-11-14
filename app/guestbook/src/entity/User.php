<?php
declare(strict_types=1);

namespace Piv\Guestbook\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={@ORM\Index(name="search_idx", columns={"email"})})
 */
class User
{
    /** @ORM\Id @ORM\Column(name="user_id", type="integer", unique=true, nullable=true) @ORM\GeneratedValue**/
    protected $idUser;
    /** @ORM\Column(length=128) **/
    protected $name;
    /** @ORM\Column(length=128) **/
    protected $email;
    /** @ORM\Column(type="string", length=128) **/
    protected $password;
    /** @ORM\Column(type="string", length=10) **/
    protected $role;
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
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
        return $this->idUser;
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
     * @param string $name
     * @return void
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
     * @param string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    /**
     * $password getter
     * @return string $password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * $password setter
     * @param string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    /**
     * $role getter
     * @return string $role
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * $role setter
     * @param string $role
     * @return void
     */
    public function setRole(string $role = 'USER')
    {
        $this->role = $role;
    }
    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @param Message $message
     * @return User
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
