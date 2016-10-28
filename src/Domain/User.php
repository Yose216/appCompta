<?php

namespace appCompta\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{

    private $id;
    private $userName;
    private $userColor;
    //Values : ROLE_USER or ROLE_ADMIN.
    private $userRole;
    private $userPwd;
    private $salt;
	
	public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

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
	
	public function eraseCredentials() {
        // Nothing to do here
    }
}
