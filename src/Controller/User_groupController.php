<?php

namespace appCompta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\User_group;

class User_groupController {
	// Get all groups
	public function getAllGroup(Application $app) {
			$user_group = $app['dao.user_group']->findAll();
			$responseData = array();
			foreach ($user_group as $users_group) {
				$responseData[] = array(
					'Id' => $users_group->getId(),
					'groupname' => $users_group->getGroupname()
				);
			}
			return $app->json($responseData);
	}
	
	// Get one group
	public function getOneUserGroup($id, Request $request, Application $app) {
		$user_group = $app['dao.user_group']->find($id);
		if (!isset($user_group)) {
			$app->abort(404, 'User not exist');
		}

		$responseData = array(
			'Id' => $user_group->getId(),
			'groupname' => $user_group->getGroupname()
		);
		return $app->json($responseData);
	}
	
	// Create user group
	public function createUserGroup(Request $request, Application $app) {
		if (!$request->request->has('groupname')) {
			return $app->json('Missing parameter: groupname', 400);
		}

		$user_group = new User_group();
		$user_group->setGroupname($request->request->get('groupname'));
		$app['dao.user_group']->save($user_group);

		$responseData = array(
			'Id' => $user_group->getId(),
			'groupname' => $user_group->getGroupname()
		);

		return $app->json($responseData, 201);
	}
	
	// Edit user group
	public function editUserGroup($id, Request $request, Application $app) {
		$user_group = $app['dao.user_group']->find($id);

		$user_group->setGroupname($request->request->get('groupname'));
		$app['dao.user_group']->save($user_group);

		$responseData = array(
			'Id' => $user_group->getId(),
			'groupname' => $user_group->getGroupname()
		);

		return $app->json($responseData, 202);
	}
	
	// Delete user group
	public function deleteUserGroup($id, Request $request, Application $app) {
		$app['dao.user_group']->delete($id);
		
		return $app->json('No content', 204);
	}
}