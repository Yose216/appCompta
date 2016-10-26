<?php

namespace appCompta\DAO;

use appCompta\Domain\Concernes;

class ConcernesDAO extends DAO {

	public function findAll() {
        $sql = "select * from concernes";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = [];
        foreach ($result as $row) {
			array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }

	protected function buildDomainObject($row) {
        $concernes = new Concernes();
        $concernes->setIddepenses($row['id_depenses']);
        $concernes->setIdusers($row['id_users']);
        return $concernes;
    }

	public function save(Concernes $concernes) {
        $concernesData = array(
            'id_depenses' => $concernes->getIddepenses(),
			'id_users' => $concernes->getIdusers()
            );

        $this->getDb()->insert('concernes', $concernesData);
    }
}
