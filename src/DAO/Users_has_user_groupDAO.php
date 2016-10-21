<?php

namespace appCompta\DAO;

use appCompta\Domain\Users_has_user_group;

class Users_has_user_groupDAO extends DAO {
	
	public function findAll() {
        $sql = "select * from users_has_user_group";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = [];
        foreach ($result as $row) {
//            $entities =
			array_push($entities, $this->buildDomainObject($row));
        }
        return $entities;
    }
	
	protected function buildDomainObject($row) {
        $users_has_user_group = new Users_has_user_group();
        $users_has_user_group->setUserid($row['user_id']);
        $users_has_user_group->setIdusergroup($row['id_user_group']);
        return $users_has_user_group;
    }
	
	public function save(Users_has_user_group $users_has_user_group) {
        $userHasUserGroupData = array(
            'user_id' => $users_has_user_group->getUserid(),
			'id_user_group' => $users_has_user_group->getIdusergroup()
            );

        $this->getDb()->insert('users_has_user_group', $userHasUserGroupData);
    }
	
}
