<?php
declare(strict_types=1);

namespace Piv\Guestbook\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Piv\Guestbook\Repository\MessageRepository")
 * @ORM\Table(name="messages", indexes={@ORM\Index(name="search_idx", columns={"theme", "date"})})
 */
class Message
{
    /** @ORM\Id @ORM\Column(name="message_id", type="integer", unique=true, nullable=true) @ORM\GeneratedValue **/
    protected $idMessage;
    /** @ORM\Column(type="string", length=128) **/
    protected $theme;
    /** @ORM\Column(type="text") **/
    protected $text;
    /** @ORM\Column(type="string", length=128, nullable=true) **/
    protected $pictures;
    /** @ORM\Column(type="string", length=255, nullable=true) **/
    protected $filepath;
    /** @ORM\Column(type="datetime") **/
    protected $date;
    /** @ORM\Column(name="ip", type="string", length=128) **/
    protected $ipAdress;
    /** @ORM\Column(type="string", length=128) **/
    protected $browser;
    /** @ORM\Column(name="annotation_for_id", type="integer") **/
    protected $annotationForId;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true)
     */
    protected $user;

    /**
     * $idMessage getter
     * @return integer $idMessage
     */
    public function getId(): int
    {
        return $this->idMessage;
    }
    /**
     * $theme getter
     * @return string $theme
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * $theme setter
     * @param string $theme
     * @return void
     */
    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }
    /**
     * $text getter
     * @return string $text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * $text setter
     * @param string $text
     * @return void
     */
    public function setText(string $text): void
    {
        $bbcode = ["[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]"];
        $htmltag = ["<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>"];
        $text = str_replace($bbcode, $htmltag, $text);
        $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function ($match) {
            return '<a href="' . $match[1] . '" target="_blank">' . (empty($match[2]) ? $match[1] : $match[2]) . '</a>';
        }, $text);
        $this->text = $text;
    }
    /**
     * $pictures getter
     * @return string $pictures
     */
    public function getPictures(): ?string
    {
        return $this->pictures;
    }

    /**
     * $pictures setter
     * @param string $pictures
     * @return void
     */
    public function setPictures(string $pictures): void
    {
        $this->pictures = $pictures;
    }
    /**
     * $filepath getter
     * @return string $filepath
     */
    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    /**
     * $filepath setter
     * @param string $filepath
     * @return void
     */
    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }
    /**
     * $date getter
     * @return datetime $date
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * $date setter
     * @param DateTime $date
     * @return void
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
    /**
     * $ipAdress getter
     * @return string $ipAdress
     */
    public function getIp(): ?string
    {
        return $this->ipAdress;
    }

    /**
     * $ipAdress setter
     * @param string $ipAdress
     * @return void
     */
    public function setIp(string $ipAdress): void
    {
        $this->ipAdress = $ipAdress;
    }
    /**
     * $browser getter
     * @return mixed $browser
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * $browser setter
     * @param string $browser
     * @return void
     */
    public function setBrowser(string $browser): void
    {
        $this->browser = $browser;
    }

     /**
      * $annotationForId getter
      * @return integer $annotationForId
      */
     public function getAnnotationForId(): ?int
     {
         return $this->annotationForId;
     }

     /**
      * $annotationForId setter
      * @param integer $annotationForId
      * @return void
      */
     public function setAnnotationForId(int $annotationForId): void
     {
         $this->annotationForId = $annotationForId;
     }
     /**
      * $user getter
      * @return User|null $user
      */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * $user setter
     * @param User|null $user
     * @return void
     */
    public function setUser(User $user = null): void
    {
        $user->addMessage($this);
        $this->user = $user;
    }
    /**
     * convert properties to array
     * @return array of class properties
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
