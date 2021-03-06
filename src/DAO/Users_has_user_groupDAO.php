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
	
	public function delete($id) {
        // Delete users_has_user_group whith the user_id
        $this->getDb()->delete('users_has_user_group', array('user_id' => $id));
    }

	public function deleteUserGroup($id) {
        // Delete the users_has_user_group whith the id_user_group
        $this->getDb()->delete('users_has_user_group', array('id_user_group' => $id));
    }
}
