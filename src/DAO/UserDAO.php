<?php

namespace appCompta\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use appCompta\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
{
	
	/*
     * Returns a list of all users, sorted by role and name.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "SELECT * FROM users order by user_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['user_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
	
    /*
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     *
     * @return \appCompta\Domain\User|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from users where user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }
		
	public function login($username, $password) {
		$sql = "SELECT * FROM users WHERE user_name =? AND user_pwd =?";
		$result = $this->getDb()->query($sql,$username,$password); 
		if(!empty($result)) {
			return $result;
		}
	}
	
    public function loadUserByUsername($userName)
    {
        $sql = "select * from users where user_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($userName));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $userName));
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return 'appCompta\Domain\User' === $class;
    }

    /*
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \appCompta\Domain\User
     */
    protected function buildDomainObject($row) {
        $user = new User();
        $user->setId($row['user_id']);
        $user->setUsername($row['user_name']);
        $user->setUsercolor($row['user_color']);
        $user->setRole($row['user_role']);
		$user->setPassword($row['user_pwd']);
		$user->setSalt($row['user_salt']);
        return $user;
    }
	
	/*
     * Saves a user into the database.
     *
     * @param \appCompta\Domain\User $user The user to save
     */
    public function save(User $user) {
        $userData = array(
            'user_name' => $user->getUsername(),
            'user_color' => $user->getUsercolor(),
            'user_role' => $user->getRole(),
			'user_pwd' => $user->getPassword(),
			'user_salt' => $user->getSalt()
            );

        if ($user->getId()) {
            // The user has already been saved : update it
            $this->getDb()->update('users', $userData, array('user_id' => $user->getId()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('users', $userData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
		return $user;
    }

    /**
     * Removes a user from the database.
     *
     * @param @param integer $id The user id.
     */
    public function delete($id) {
        // Delete the user
        $this->getDb()->delete('users', array('user_id' => $id));
    }
}
