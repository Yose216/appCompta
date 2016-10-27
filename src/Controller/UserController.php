<?php
namespace appCompta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\User;
use appCompta\Domain\Users_has_user_group;
use appCompta\Domain\Concernes;

class UserController {

	public function getAllUsers(Application $app) {
		$users = $app['dao.user']->findAll();
		$user_has_group = $app['dao.user_has_user_group']->findAll();
		$responseData = array();
		
		/* Converts $user_has_group to an array $user2GroupArray having structure : 
		*	[UserId => [groupId], UserID2 => [groupeId2]]
		*/
		$user2GroupArray= [];
		foreach($user_has_group as $obj){
			if(! array_key_exists($obj->getUserid(), $user2GroupArray)){
				$user2GroupArray[$obj->getUserid()] = [];
			}
			array_push($user2GroupArray[$obj->getUserid()], $obj->getIdusergroup());
		}

		foreach ($users as $user) {
			$responseData[] = array(
				'Id' => $user->getId(),
				'username' => $user->getUsername(),
				'usercolor' => $user->getUsercolor(),
				'usergroup' => implode(", ", $user2GroupArray[$user->getId()])
			);
		}
		return $app->json($responseData);
	}
	
	// Get on user
	public function getOneUser($id, Request $request, Application $app) {
		$user = $app['dao.user']->find($id);
		$user_has_group = $app['dao.user_has_user_group']->findAll();
		if (!isset($user)) {
			$app->abort(404, 'User not exist');
		}

		$user2GroupArray= [];
		foreach($user_has_group as $obj){
			if(! array_key_exists($obj->getUserid(), $user2GroupArray)){
				$user2GroupArray[$obj->getUserid()] = [];
			}
			array_push($user2GroupArray[$obj->getUserid()], $obj->getIdusergroup());
		}

		$responseData = array(
			'Id' => $user->getId(),
			'username' => $user->getUsername(),
			'usercolor' => $user->getUsercolor(),
			'usergroup' => implode(", ", $user2GroupArray[$user->getId()])
		);
		return $app->json($responseData);
	}
	
	// Create user
	public function createUser(Request $request, Application $app) {
		if (!$request->request->has('username')) {
			return $app->json('Missing parameter: username', 400);
		}
		if (!$request->request->has('usercolor')) {
			return $app->json('Missing parameter: usercolor', 400);
		}

		$user = new User(); // Set the parametre for the new user
		$user->setUsername($request->request->get('username'));
		$user->setUsercolor($request->request->get('usercolor'));
		$user->setRole($request->request->get('userrole'));
		$user->setPassword($request->request->get('userpwd'));
		$user->setSalt($request->request->get('usersalt'));
		$user = $app['dao.user']->save($user);

		// Set the parametre for the new Users_has_user_group
		$user_has_group = new Users_has_user_group();
		$user_has_group->setUserid($user->getId());
		$user_has_group->setIdusergroup($request->request->get('idusergroup'));
		$app['dao.user_has_user_group']->save($user_has_group);
		
		// Response of the create request
		$responseData = array(
			'Id' => $user->getId(),
			'username' => $user->getUsername(),
			'usercolor' => $user->getUsercolor(),
			'userrole' => $user->getRole(),
			'usergroup' => $user_has_group->getIdusergroup()
		);

		return $app->json($responseData, 201);
	}
	
	// Edit user
	public function editUser($id, Request $request, Application $app) {
		$user = $app['dao.user']->find($id);
		$user_has_group = $app['dao.user_has_user_group']->findAll();

		$user->setUsername($request->request->get('username'));
		$user->setUsercolor($request->request->get('usercolor'));
		$user->setRole($request->request->get('userrole'));
		$user->setPassword($request->request->get('userpwd'));
		$app['dao.user']->save($user);

		// for user_has_group
			//CHECK IF ALREADY EXISTS
		//end for
		/* if not exists
			--> create */
		$user_has_group = new Users_has_user_group();
		$user_has_group->setUserid($user->getId());
		$user_has_group->setIdusergroup($request->request->get('idusergroup'));
		$app['dao.user_has_user_group']->save($user_has_group);

		$responseData = array(
			'Id' => $user->getId(),
			'username' => $user->getUsername(),
			'usercolor' => $user->getUsercolor(),
			'userrole' => $user->getRole(),
			'idusergroup' => $user_has_group->getIdusergroup()
		);

		return $app->json($responseData, 202);
	}
	
	// Delete user
	public function deleteUser($id, Request $request, Application $app) {
		$app['dao.concernes']->delete($id);
		$app['dao.user_has_user_group']->delete($id);
		$app['dao.user']->delete($id);
		return $app->json('No content', 204);
	}

	
}
