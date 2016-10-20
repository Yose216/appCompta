<?php

namespace appCompta\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
   /**
     * User id.
     *
     * @var integer
     */
    private $id;
	
	/**
     * User name.
     *
     * @var string
     */
    private $userName;
	
	/**
     * User color.
     *
     * @var string
     */
    private $userColor;
	
	/**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
	 *
     * @var string
     */
    private $userRole;
	
	/**
     * User password.
     *
     * @var string
     */
    private $userPwd;
	
	/**
     * User salt.
     *
     * @var string
     */
    private $salt;
	
//	private $groups;
	
	public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->userName;
    }

    public function setUsername($userName) {
        $this->userName = $userName;
    }
	
	public function getUsercolor() {
		return $this->userColor;
	}
	
	public function setUsercolor($userColor) {
		$this->userColor = $userColor;
	}
	
    public function getRole() {
        return $this->userRole;
    }

    public function setRole($userRole) {
        $this->userRole = $userRole;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }
	
	public function getPassword() {
        return $this->userPwd;
    }

    public function setPassword($userPwd) {
        $this->userPwd = $userPwd;
    }
	
	public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }
	
//	public function getGroup() { 
//		return $this->groups; 
//	}
//	
//	public function setGroup($groups) {
//		return $this->groups;
//	}
	
	public function eraseCredentials() {
        // Nothing to do here
    }
	
}