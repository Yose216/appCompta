<?php

namespace appCompta\Domain;

class Concernes {

	private $id_depenses;
	private $id_users;

	public function getIddepenses() {
        return $this->id_depenses;
    }

    public function setIddepenses($id_depenses) {
        $this->id_depenses = $id_depenses;
    }

    public function getIdusers() {
        return $this->id_users;
    }

    public function setIdusers($id_users) {
        $this->id_users = $id_users;
    }
}
