<?php
namespace Src;

require_once 'User.php';

use Model\User;

class Session
{
    /**
     * @var Session
     */
    static $instance = null;

    /**
     * @var bool
     */
    private $isLoggedIn = false;

    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var int
     */
    private $fbId = 0;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $fName = '';

    /**
     * @var string
     */
    private $lName = '';

    /**
     * @var string
     */
    private $province = '';

    /**
     * @var int
     */
    private $phone = 0;

    /**
     * @var string
     */
    private $profession = '';

    /**
     * @var \DateTime
     */
    private $createdAt = null;

    public function __construct()
    {
        $this->populateData();
    }

    /**
     * @return Session
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->populateData();
        }

        return self::$instance;
    }

    /**
     * @param int $fbId
     */
    public function logIn($fbId)
    {
        $user = new User();
        $userData = $user->findBy('fb_id', $fbId);
        // set session data
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['id'] = $userData['id'];
        $_SESSION['fbId'] = $userData['fb_id'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['fName'] = $userData['f_name'];
        $_SESSION['lName'] = $userData['l_name'];
        $_SESSION['province'] = $userData['province'];
        $_SESSION['phone'] = $userData['phone'];
        $_SESSION['profession'] = $userData['profession'];
        $_SESSION['profile'] = $userData['profile'];
        $_SESSION['createdAt'] = new \DateTime($userData['created_at']);

        $this->populateData();
    }

    /**
     * populates object properties
     */
    public function populateData()
    {
        foreach ($_SESSION as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return boolean
     */
    public function getIsLoggedIn()
    {
        return $this->isLoggedIn;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFbId()
    {
        return $this->fbId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFName()
    {
        return $this->fName;
    }

    /**
     * @return string
     */
    public function getLName()
    {
        return $this->lName;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}