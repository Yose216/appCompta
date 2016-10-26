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

}
