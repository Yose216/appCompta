<?php

namespace appCompta\DAO;

use appCompta\Domain\Depenses;

class DepensesDAO extends DAO {

	public function findAll() {
        $sql = "select * from depenses";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = [];
        foreach ($result as $row) {
			array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

	public function find($id) {
        $sql = "select * from depenses where id_depenses=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user_group matching id " . $id);
    }

	protected function buildDomainObject($row) {
        $depenses = new Depenses();
        $depenses->setIddepenses($row['id_depenses']);
        $depenses->setMontant($row['montant']);
		$depenses->setPayeurs($row['payeurs']);
		$depenses->setDatedep($row['date']);
		$depenses->setNbconcerne($row['nbConcerne']);
		$depenses->setDescription($row['description']);
        return $depenses;
    }

	public function save(Depenses $depenses) {
        $depenseData = array(
            'montant' => $depenses->getMontant(),
			'payeurs' => $depenses->getPayeurs(),
			'date' => $depenses->getDatedep()->format('Y-m-d H:i:s'),
			'nbConcerne' => $depenses->getNbconcerne(),
			'description' => $depenses->getDescription()
            );

        if ($depenses->getIddepenses()) {
            // The user has already been saved : update it
            $this->getDb()->update('depenses', $depenseData, array('id_depenses' => $depenses->getIddepenses()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('depenses', $depenseData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $depenses->setIddepenses($id);
        }
    }

}
