<?php
declare(strict_types=1);

namespace Piv\Guestbook\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={@ORM\Index(name="search_idx", columns={"email"})})
 */
class User implements UserInterface, \Serializable
{
    /** @ORM\Id @ORM\Column(name="user_id", type="integer", unique=true, nullable=true) @ORM\GeneratedValue**/
    protected $idUser;
    /** @ORM\Column(length=128) **/
    protected $username;
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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * $name setter
     * @param string $name
     * @return void
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
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
    public function getRoles(): ?string
    {
        return $this->role;
    }

    /**
     * $role setter
     * @param string $role
     * @return void
     */
    public function setRoles(string $role = 'USER')
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
    public function getSalt(): ?string
    {
        return null;
    }
    public function eraseCredentials(): void
    {
      //
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

    public function serialize(): string
    {
        return serialize([$this->id, $this->name, $this->password]);
    }
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

}
