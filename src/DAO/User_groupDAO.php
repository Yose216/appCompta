<?php

namespace appCompta\DAO;

use appCompta\Domain\User_group;

class User_groupDAO extends DAO {
	
    // Returns a list of all users_group order by id
    public function findAll() {
        $sql = "select * from user_group order by id_user_group";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_user_group'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
	
	// Returns a user_group matching the supplied id.
    public function find($id) {
        $sql = "select * from user_group where id_user_group=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user_group matching id " . $id);
    }

	// Create user group
    protected function buildDomainObject($row) {
        $user_group = new User_group();
        $user_group->setId($row['id_user_group']);
        $user_group->setGroupname($row['group_name']);
        return $user_group;
    }
	
	// Save user group in DB
    public function save(User_group $user_group) {
        $groupData = array(
            'group_name' => $user_group->getGroupname()
            );

        if ($user_group->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('user_group', $groupData, array('id_user_group' => $user_group->getId()));
        }
		else {
            // The user has never been saved : insert it
            $this->getDb()->insert('user_group', $groupData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user_group->setId($id);
        }
    }

	// Delete user group
    public function delete($id) {
        $this->getDb()->delete('user_group', array('id_user_group' => $id));
    }
}
