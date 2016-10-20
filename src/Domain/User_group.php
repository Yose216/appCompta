<?php

namespace appCompta\Domain;

class User_group {
	/**
     * User Group id.
     *
     * @var integer
     */
    private $id;

    /**
     * Group name.
     *
     * @var string
     */
    private $groupName;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getGroupname() {
        return $this->groupName;
    }

    public function setGroupname($groupName) {
        $this->groupName = $groupName;
    }
}