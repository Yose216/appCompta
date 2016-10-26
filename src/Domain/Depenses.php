<?php

namespace appCompta\Domain;

class Depenses {
	private $id_depenses;
	private $montant;
	private $payeurs;
	private $dateDep;
	private $nbConcerne;
	private $description;
	
	public function getIddepenses() {
		return $this->id_depenses;
	}

	public function setIddepenses($id_depenses) {
		$this->id_depenses = $id_depenses;
	}

	public function getMontant() {
		return $this->montant;
	}

	public function setMontant($montant) {
		$this->montant = $montant;
	}

	public function getPayeurs() {
		return $this->payeurs;
	}

	public function setPayeurs($payeurs) {
		$this->payeurs = $payeurs;
	}

	public function getDatedep() {
		if(is_string($this->dateDep)){
			$this->dateDep = \DateTime::createFromFormat('Y-m-d H:i:s', $this->dateDep);
		}
        return $this->dateDep;
    }

    public function setDatedep($dateDep) {
		if(! is_string($dateDep)){
			$dateDep = $dateDep->format('Y-m-d H:i:s');
		}
        $this->dateDep = $dateDep;
    }

	public function getNbconcerne() {
		return $this->nbConcerne;
	}

	public function setNbconcerne($nbConcerne) {
		$this->nbConcerne = $nbConcerne;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}
}
