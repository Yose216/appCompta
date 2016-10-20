<?php

namespace appCompta\Domain;

class Users_has_user_group {
	/**
     * user id.
     *
     * @var integer
     */
    private $userId;

    /**
     * id user group.
     *
     * @var integer
     */
    private $idUserGroup;

    public function getUserid() {
        return $this->userId;
    }

    public function setUserid($userId) {
        $this->userId = $userId;
    }

    public function getIdusergroup() {
        return $this->idUserGroup;
    }

    public function setIdusergroup($idUserGroup) {
        $this->idUserGroup = $idUserGroup;
    }

}