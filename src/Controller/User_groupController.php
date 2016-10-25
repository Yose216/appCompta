<?php

namespace appCompta\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\User_group;
use appCompta\Domain\Users_has_user_group;


class User_groupController {
	// Get all groups
	public function getAllGroup(Application $app) {
		$user_group = $app['dao.user_group']->findAll();
		$user_has_group = $app['dao.user_has_user_group']->findAll();
		$responseData = array();
		$user2GroupArray= [];

		foreach($user_has_group as $obj){
			if(! array_key_exists($obj->getIdusergroup(), $user2GroupArray)){
				$user2GroupArray[$obj->getIdusergroup()] = [];
			}
			array_push($user2GroupArray[$obj->getIdusergroup()], $obj->getUserid());
		}

		foreach ($user_group as $users_group) {
			$responseData[] = array(
				'Id' => $users_group->getId(),
				'groupname' => $users_group->getGroupname(),
				'userid' => implode(", ", $user2GroupArray[$users_group->getId()])
			);
		}
		return $app->json($responseData);
	}
	
	// Get one group
	public function getOneUserGroup($id, Request $request, Application $app) {
		$user_group = $app['dao.user_group']->find($id);
		$user_has_group = $app['dao.user_has_user_group']->findAll();
		if (!isset($user_group)) {
			$app->abort(404, 'User not exist');
		}

		$user2GroupArray= [];
		foreach($user_has_group as $obj){
			if(! array_key_exists($obj->getIdusergroup(), $user2GroupArray)){
				$user2GroupArray[$obj->getIdusergroup()] = [];
			}
			array_push($user2GroupArray[$obj->getIdusergroup()], $obj->getUserid());
		}

		$responseData = array(
			'Id' => $user_group->getId(),
			'groupname' => $user_group->getGroupname(),
			'userid' => implode(", ", $user2GroupArray[$user_group->getId()])
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
