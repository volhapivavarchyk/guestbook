<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="messages")
 */
class Message
{
    /** @Id @Column(name="message_id", type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $theme;
    /** @Column(type="string") **/
    protected $text;
    /** @Column(type="string") **/
    protected $pictures;
    /** @Column(type="string") **/
    protected $filepath;
    /** @Column(type="datetime") **/
    protected $date;
    /** @Column(type="string") **/
    protected $ip;
    /** @Column(type="string") **/
    protected $browser;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="commentsAuthored")
     * @JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true)
     */
    protected $user;

    /**
     * $id getter
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * $theme getter
     * @return string $theme
     */
    public function getTheme()
    {
        return $this->theme;
    }
    /**
     * $theme setter
     * @return
     */
    public function setTheme(string $theme)
    {
        $this->theme = $theme;
    }
    /**
     * $text getter
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * $text setter
     * @return
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }
    /**
     * $pictures getter
     * @return string $pictures
     */
    public function getPictures()
    {
        return $this->pictures;
    }
    /**
     * $pictures setter
     * @return
     */
    public function setPictures(string $pictures)
    {
        $this->pictures = $pictures;
    }
    /**
     * $filepath getter
     * @return string $filepath
     */
    public function getFilepath()
    {
        return $this->filepath;
    }
    /**
     * $filepath setter
     * @return
     */
    public function setFilepath(string $filepath)
    {
        $this->filepath = $filepath;
    }
    /**
     * $date getter
     * @return datetime $date
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * $date setter
     * @return
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    /**
     * $ip getter
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }
    /**
     * $ip setter
     * @return
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }
    /**
     * $browser getter
     * @return mixed $browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }
    /**
     * $browser setter
     * @return
     */
    public function setBrowser(string $browser)
    {
        $this->browser = $browser;
    }
    /**
     * $user getter
     * @return integer $user
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * $user setter
     * @return
     */
    public function setUser(User $user = null)
    {
        $user->addMessage($this);
        $this->user = $user;
    }
    /**
     * convert properties to array
     * @return array of class properties
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
