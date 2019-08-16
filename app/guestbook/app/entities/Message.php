<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Entities;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * @Entity
 * @Table(name="messages", indexes={@Index(name="search_idx", columns={"theme", "date"})})
 */
class Message
{
    /** @Id @Column(name="message_id", type="integer", unique=true, nullable=true) @GeneratedValue **/
    protected $id;
    /** @Column(type="string", length=128) **/
    protected $theme;
    /** @Column(type="text") **/
    protected $text;
    /** @Column(type="string", length=128, nullable=true) **/
    protected $pictures;
    /** @Column(type="string", length=255, nullable=true) **/
    protected $filepath;
    /** @Column(type="datetime") **/
    protected $date;
    /** @Column(type="string", length=128) **/
    protected $ip;
    /** @Column(type="string", length=128) **/
    protected $browser;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="messages", cascade={"persist"})
     * @JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true)
     */
    protected $user;

    /**
     * $id getter
     * @return integer $id
     */
    public function getId(): ?integer
    {
        return $this->id;
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
     * @return
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
     * @return
     */
    public function setText(string $text): void
    {
        var_dump($text);
        $bbcode = ["[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]"];
        $htmltag = ["<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>"];
        $text = str_replace($bbcode, $htmltag, $text);
        $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function ($match) {
            return '<a href="' . $match[1] . '" target="_blank">' . (empty($match[2]) ? $match[1] : $match[2]) . '</a>';
        }, $text);
        var_dump($text);
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
     * @return
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
     * @return
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
     * @return
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
    /**
     * $ip getter
     * @return string $ip
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }
    /**
     * $ip setter
     * @return
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
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
     * @return
     */
    public function setBrowser(string $browser): void
    {
        $this->browser = $browser;
    }
    /**
     * $user getter
     * @return integer $user
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
    /**
     * $user setter
     * @return
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
